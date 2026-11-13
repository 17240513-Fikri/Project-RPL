@extends('layouts.app')

@section('title', 'Detail Warga')
@section('subtitle', $resident->name)

@section('topbar')
    <div class="actions">
        <a class="btn secondary" href="{{ route('residents.index') }}">Kembali</a>
        <a class="btn" href="{{ route('residents.edit', $resident) }}">Edit</a>
    </div>
@endsection

@section('content')
<div class="grid grid-2">
    <section class="card">
        <h2>Identitas</h2>
        <dl class="detail-list">
            <dt>NIK</dt><dd>{{ $resident->nik }}</dd>
            <dt>Nama</dt><dd>{{ $resident->name }}</dd>
            <dt>Jenis Kelamin</dt><dd>{{ $resident->gender }}</dd>
            <dt>TTL</dt><dd>{{ $resident->birth_place ?: '-' }}, {{ optional($resident->birth_date)->format('d M Y') ?: '-' }}</dd>
            <dt>Agama</dt><dd>{{ $resident->religion ?: '-' }}</dd>
            <dt>Pendidikan</dt><dd>{{ $resident->education ?: '-' }}</dd>
            <dt>Pekerjaan</dt><dd>{{ $resident->occupation ?: '-' }}</dd>
            <dt>Status Warga</dt><dd><span class="badge {{ $resident->resident_status === 'aktif' ? 'success' : 'warning' }}">{{ ucwords($resident->resident_status) }}</span></dd>
        </dl>
    </section>

    <section class="card">
        <h2>Keluarga & Kontak</h2>
        <dl class="detail-list">
            <dt>Nomor KK</dt><dd>{{ optional($resident->household)->family_card_number ?: '-' }}</dd>
            <dt>Status Keluarga</dt><dd>{{ $resident->family_status ?: '-' }}</dd>
            <dt>Perkawinan</dt><dd>{{ $resident->marital_status ?: '-' }}</dd>
            <dt>Kewarganegaraan</dt><dd>{{ $resident->citizenship ?: '-' }}</dd>
            <dt>Gol. Darah</dt><dd>{{ $resident->blood_type ?: '-' }}</dd>
            <dt>Telepon</dt><dd>{{ $resident->phone ?: '-' }}</dd>
            <dt>Email</dt><dd>{{ $resident->email ?: '-' }}</dd>
            <dt>Alamat KTP</dt><dd>{{ $resident->address_on_id ?: '-' }}</dd>
        </dl>
    </section>
</div>

<section class="card" style="margin-top: 18px;">
    <h2>Riwayat Surat</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Jenis Surat</th><th>Status</th><th>Tanggal</th></tr></thead>
            <tbody>
            @forelse($resident->letterRequests as $letter)
                <tr>
                    <td><a href="{{ route('letters.show', $letter) }}">{{ $letter->type->name }}</a></td>
                    <td><span class="badge {{ $letter->status }}">{{ ucwords($letter->status) }}</span></td>
                    <td>{{ $letter->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="empty-state">Belum ada riwayat surat.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
