<?php

namespace App\Http\Controllers;

use App\Models\LetterRequest;
use App\Models\LetterType;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LetterRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LetterRequest::with(['type', 'resident', 'requester'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status));

        if (! $request->user()->isAdmin()) {
            $query->where('diajukan_oleh', $request->user()->id);
        }

        return view('letters.index', [
            'letters' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create(Request $request)
    {
        return view('letters.create', [
            'letterTypes' => LetterType::where('aktif', true)->orderBy('nama')->get(),
            'residents' => $request->user()->isAdmin() ? Resident::orderBy('nama')->get() : collect([$request->user()->resident])->filter(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'letter_type_id' => ['required', 'exists:jenis_surat,id'],
            'resident_id' => [$request->user()->isAdmin() ? 'required' : 'nullable', 'exists:warga,id'],
            'purpose' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $residentId = $request->user()->isAdmin() ? $data['resident_id'] : $request->user()->resident_id;

        if (! $residentId) {
            return back()->withErrors(['resident_id' => 'Akun warga belum terhubung dengan data warga. Hubungi admin.'])->withInput();
        }

        LetterRequest::create([
            'letter_type_id' => $data['letter_type_id'],
            'resident_id' => $residentId,
            'requested_by' => $request->user()->id,
            'purpose' => $data['purpose'],
            'notes' => $data['notes'] ?? null,
            'status' => 'diajukan',
        ]);

        return redirect()->route('letters.index')->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public function show(Request $request, LetterRequest $letter)
    {
        $this->ensureCanView($request, $letter);

        $letter->load(['type', 'resident.household', 'requester', 'processor']);

        return view('letters.show', compact('letter'));
    }

    public function updateStatus(Request $request, LetterRequest $letter)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'])],
            'notes' => ['nullable', 'string'],
            'rejection_reason' => ['nullable', 'required_if:status,ditolak', 'string'],
        ]);

        $letter->status = $data['status'];
        $letter->notes = $data['notes'] ?? $letter->notes;
        $letter->processed_by = Auth::id();

        if ($data['status'] === 'disetujui') {
            $letter->request_number = $letter->request_number ?: $this->generateRequestNumber($letter);
            $letter->approved_at = now();
        }

        if ($data['status'] === 'ditolak') {
            $letter->rejection_reason = $data['rejection_reason'];
        }

        if ($data['status'] === 'selesai') {
            $letter->completed_at = now();
        }

        $letter->save();

        return redirect()->route('letters.show', $letter)->with('success', 'Status surat berhasil diperbarui.');
    }

    private function ensureCanView(Request $request, LetterRequest $letter): void
    {
        if (! $request->user()->isAdmin() && $letter->requested_by !== $request->user()->id) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }
    }

    private function generateRequestNumber(LetterRequest $letter): string
    {
        $letter->loadMissing('type');
        $sequence = LetterRequest::whereYear('dibuat_pada', now()->year)->count() + 1;

        return sprintf('%s/%s/%04d', $letter->type->code, now()->format('m/Y'), $sequence);
    }
}
