<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CashTransaction;
use App\Models\CommunityProfile;
use App\Models\Household;
use App\Models\LetterRequest;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $isAdmin = $user->isAdmin();

        $income = CashTransaction::where('jenis', 'pemasukan')->sum('jumlah');
        $expense = CashTransaction::where('jenis', 'pengeluaran')->sum('jumlah');

        $letterQuery = LetterRequest::with(['type', 'resident'])->latest();
        if (! $isAdmin) {
            $letterQuery->where('diajukan_oleh', $user->id);
        }

        $monthlyCash = collect(range(5, 0))->map(function (int $monthsAgo) {
            $month = Carbon::now()->subMonths($monthsAgo);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            return [
                'label' => $month->format('M Y'),
                'income' => CashTransaction::where('jenis', 'pemasukan')->whereBetween('tanggal_transaksi', [$start, $end])->sum('jumlah'),
                'expense' => CashTransaction::where('jenis', 'pengeluaran')->whereBetween('tanggal_transaksi', [$start, $end])->sum('jumlah'),
            ];
        });

        return view('dashboard', [
            'profile' => CommunityProfile::first(),
            'stats' => [
                'residents' => Resident::count(),
                'households' => Household::count(),
                'letters_pending' => LetterRequest::whereIn('status', ['diajukan', 'diproses'])->count(),
                'cash_balance' => $income - $expense,
                'cash_income' => $income,
                'cash_expense' => $expense,
            ],
            'latestLetters' => $letterQuery->limit(6)->get(),
            'latestAnnouncements' => Announcement::where('terbit', true)->latest('terbit_pada')->limit(5)->get(),
            'monthlyCash' => $monthlyCash,
            'isAdmin' => $isAdmin,
        ]);
    }
}
