<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CashTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = CashTransaction::with('recorder')
            ->when($request->filled('type'), fn ($q) => $q->where('jenis', $request->type))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search');
                $q->where(function ($sub) use ($search) {
                    $sub->where('kategori', 'like', "%{$search}%")
                        ->orWhere('kode_transaksi', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%");
                });
            });

        $income = CashTransaction::where('jenis', 'pemasukan')->sum('jumlah');
        $expense = CashTransaction::where('jenis', 'pengeluaran')->sum('jumlah');

        return view('cash.index', [
            'transactions' => $query->latest('tanggal_transaksi')->paginate(10)->withQueryString(),
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
        ]);
    }

    public function create()
    {
        return view('cash.create', [
            'cashTransaction' => new CashTransaction(['transaction_date' => now()]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['transaction_code'] = $this->generateCode($data['type']);
        $data['recorded_by'] = Auth::id();

        CashTransaction::create($data);

        return redirect()->route('cash.index')->with('success', 'Transaksi kas berhasil ditambahkan.');
    }

    public function show(CashTransaction $cashTransaction)
    {
        $cashTransaction->load('recorder');

        return view('cash.show', compact('cashTransaction'));
    }

    public function edit(CashTransaction $cashTransaction)
    {
        return view('cash.edit', compact('cashTransaction'));
    }

    public function update(Request $request, CashTransaction $cashTransaction)
    {
        $cashTransaction->update($this->validatedData($request));

        return redirect()->route('cash.index')->with('success', 'Transaksi kas berhasil diperbarui.');
    }

    public function destroy(CashTransaction $cashTransaction)
    {
        $cashTransaction->delete();

        return redirect()->route('cash.index')->with('success', 'Transaksi kas berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', Rule::in(['pemasukan', 'pengeluaran'])],
            'category' => ['required', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'payment_method' => ['nullable', 'max:100'],
            'reference' => ['nullable', 'max:150'],
        ]);
    }

    private function generateCode(string $type): string
    {
        $prefix = $type === 'pemasukan' ? 'KAS-IN' : 'KAS-OUT';
        $date = now()->format('Ymd');
        $sequence = CashTransaction::whereDate('dibuat_pada', today())->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, $date, $sequence);
    }
}
