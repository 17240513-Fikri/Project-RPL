<?php

namespace App\Http\Controllers;

use App\Models\Household;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HouseholdController extends Controller
{
    public function index(Request $request)
    {
        $households = Household::with(['head', 'residents'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_kk', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%")
                        ->orWhereHas('head', fn ($head) => $head->where('nama', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('households.index', compact('households'));
    }

    public function create()
    {
        return view('households.create', [
            'household' => new Household(),
            'residents' => Resident::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Household::create($this->validatedData($request));

        return redirect()->route('households.index')->with('success', 'Data KK berhasil ditambahkan.');
    }

    public function show(Household $household)
    {
        $household->load(['head', 'residents']);

        return view('households.show', compact('household'));
    }

    public function edit(Household $household)
    {
        return view('households.edit', [
            'household' => $household,
            'residents' => Resident::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Household $household)
    {
        $household->update($this->validatedData($request, $household));

        return redirect()->route('households.index')->with('success', 'Data KK berhasil diperbarui.');
    }

    public function destroy(Household $household)
    {
        $household->delete();

        return redirect()->route('households.index')->with('success', 'Data KK berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Household $household = null): array
    {
        return $request->validate([
            'family_card_number' => ['required', 'max:20', Rule::unique('kartu_keluarga', 'nomor_kk')->ignore($household)],
            'head_resident_id' => ['nullable', 'exists:warga,id'],
            'address' => ['required', 'string'],
            'rt' => ['required', 'max:5'],
            'rw' => ['required', 'max:5'],
            'block' => ['nullable', 'max:100'],
            'kelurahan' => ['nullable', 'max:150'],
            'kecamatan' => ['nullable', 'max:150'],
            'city' => ['nullable', 'max:150'],
            'province' => ['nullable', 'max:150'],
            'postal_code' => ['nullable', 'max:10'],
            'home_status' => ['required', 'max:100'],
            'economic_status' => ['required', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
