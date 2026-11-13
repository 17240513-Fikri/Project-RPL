<?php

namespace App\Http\Controllers;

use App\Models\Household;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $residents = Resident::with('household')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('telepon', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status_warga', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('residents.index', compact('residents'));
    }

    public function create()
    {
        return view('residents.create', [
            'resident' => new Resident(),
            'households' => Household::orderBy('nomor_kk')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Resident::create($this->validatedData($request));

        return redirect()->route('residents.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Resident $resident)
    {
        $resident->load(['household', 'letterRequests.type']);

        return view('residents.show', compact('resident'));
    }

    public function edit(Resident $resident)
    {
        return view('residents.edit', [
            'resident' => $resident,
            'households' => Household::orderBy('nomor_kk')->get(),
        ]);
    }

    public function update(Request $request, Resident $resident)
    {
        $resident->update($this->validatedData($request, $resident));

        return redirect()->route('residents.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('residents.index')->with('success', 'Data warga berhasil dihapus.');
    }

    public function profile(Request $request)
    {
        $resident = $request->user()->resident;

        return view('residents.profile', compact('resident'));
    }

    private function validatedData(Request $request, ?Resident $resident = null): array
    {
        return $request->validate([
            'household_id' => ['nullable', 'exists:kartu_keluarga,id'],
            'nik' => ['required', 'max:20', Rule::unique('warga', 'nik')->ignore($resident)],
            'name' => ['required', 'max:255'],
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'birth_place' => ['nullable', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'religion' => ['nullable', 'max:100'],
            'education' => ['nullable', 'max:100'],
            'occupation' => ['nullable', 'max:150'],
            'marital_status' => ['nullable', 'max:100'],
            'family_status' => ['nullable', 'max:100'],
            'citizenship' => ['nullable', 'max:20'],
            'blood_type' => ['nullable', 'max:5'],
            'phone' => ['nullable', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address_on_id' => ['nullable', 'string'],
            'resident_status' => ['required', Rule::in(['aktif', 'sementara', 'pindah', 'meninggal'])],
            'arrival_date' => ['nullable', 'date'],
            'departure_date' => ['nullable', 'date', 'after_or_equal:arrival_date'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
