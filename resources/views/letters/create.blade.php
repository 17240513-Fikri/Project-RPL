@extends('layouts.app')

@section('title', 'Ajukan Surat')
@section('subtitle', 'Pilih jenis surat dan isi keperluan pengajuan.')

@section('content')
<section class="card">
    <form method="POST" action="{{ route('letters.store') }}">
        @csrf
        <div class="form-grid">
            <div class="field">
                <label for="letter_type_id">Jenis Surat</label>
                <select id="letter_type_id" name="letter_type_id" required>
                    <option value="">Pilih jenis surat</option>
                    @foreach($letterTypes as $type)
                        <option value="{{ $type->id }}" @selected(old('letter_type_id') == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="field">
                    <label for="resident_id">Warga Pemohon</label>
                    <select id="resident_id" name="resident_id" required>
                        <option value="">Pilih warga</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}" @selected(old('resident_id') == $resident->id)>{{ $resident->name }} - {{ $resident->nik }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="field full">
                <label for="purpose">Keperluan</label>
                <textarea id="purpose" name="purpose" required>{{ old('purpose') }}</textarea>
            </div>
            <div class="field full">
                <label for="notes">Catatan Tambahan</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 18px;">
            <a class="btn secondary" href="{{ route('letters.index') }}">Batal</a>
            <button class="btn" type="submit">Kirim Pengajuan</button>
        </div>
    </form>
</section>
@endsection
