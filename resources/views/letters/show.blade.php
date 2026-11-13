@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')
@section('subtitle', $letter->type->name)

@section('topbar')
    <a class="btn secondary" href="{{ route('letters.index') }}">Kembali</a>
@endsection

@section('content')
<div class="grid grid-2">
    <section class="card">
        <h2>Pengajuan</h2>
        <dl class="detail-list">
            <dt>No Surat</dt><dd>{{ $letter->request_number ?: '-' }}</dd>
            <dt>Jenis</dt><dd>{{ $letter->type->name }}</dd>
            <dt>Status</dt><dd><span class="badge {{ $letter->status }}">{{ ucwords($letter->status) }}</span></dd>
            <dt>Pemohon</dt><dd>{{ $letter->resident->name }} - {{ $letter->resident->nik }}</dd>
            <dt>Nomor KK</dt><dd>{{ optional($letter->resident->household)->family_card_number ?: '-' }}</dd>
            <dt>Diajukan</dt><dd>{{ $letter->created_at->format('d M Y H:i') }}</dd>
            <dt>Diproses oleh</dt><dd>{{ optional($letter->processor)->name ?: '-' }}</dd>
        </dl>
    </section>

    <section class="card">
        <h2>Keperluan</h2>
        <p>{{ $letter->purpose }}</p>
        @if($letter->notes)
            <h3>Catatan</h3>
            <p>{{ $letter->notes }}</p>
        @endif
        @if($letter->rejection_reason)
            <h3>Alasan Ditolak</h3>
            <p>{{ $letter->rejection_reason }}</p>
        @endif
    </section>
</div>

@if(auth()->user()->isAdmin())
    <section class="card" style="margin-top: 18px;">
        <h2>Update Status</h2>
        <form method="POST" action="{{ route('letters.status', $letter) }}">
            @csrf
            @method('PATCH')
            <div class="form-grid">
                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach(['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $letter->status) === $status)>{{ ucwords($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="rejection_reason">Alasan Ditolak</label>
                    <input id="rejection_reason" name="rejection_reason" value="{{ old('rejection_reason', $letter->rejection_reason) }}">
                </div>
                <div class="field full">
                    <label for="notes">Catatan Admin</label>
                    <textarea id="notes" name="notes">{{ old('notes', $letter->notes) }}</textarea>
                </div>
            </div>
            <div class="form-actions" style="margin-top: 18px;">
                <button class="btn" type="submit">Simpan Status</button>
            </div>
        </form>
    </section>
@endif
@endsection
