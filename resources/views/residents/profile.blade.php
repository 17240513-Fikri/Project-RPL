@extends('layouts.app')

@section('title', 'Profil Saya')
@section('subtitle', 'Data warga yang terhubung dengan akun Anda.')

@section('content')
@if($resident)
    <div class="grid grid-2">
        <section class="card">
            <h2>Identitas</h2>
            <dl class="detail-list">
                <dt>NIK</dt><dd>{{ $resident->nik }}</dd>
                <dt>Nama</dt><dd>{{ $resident->name }}</dd>
                <dt>Jenis Kelamin</dt><dd>{{ $resident->gender }}</dd>
                <dt>TTL</dt><dd>{{ $resident->birth_place ?: '-' }}, {{ optional($resident->birth_date)->format('d M Y') ?: '-' }}</dd>
                <dt>Pekerjaan</dt><dd>{{ $resident->occupation ?: '-' }}</dd>
                <dt>Status</dt><dd><span class="badge {{ $resident->resident_status === 'aktif' ? 'success' : 'warning' }}">{{ ucwords($resident->resident_status) }}</span></dd>
            </dl>
        </section>
        <section class="card">
            <h2>Keluarga & Kontak</h2>
            <dl class="detail-list">
                <dt>Nomor KK</dt><dd>{{ optional($resident->household)->family_card_number ?: '-' }}</dd>
                <dt>Status Keluarga</dt><dd>{{ $resident->family_status ?: '-' }}</dd>
                <dt>Telepon</dt><dd>{{ $resident->phone ?: '-' }}</dd>
                <dt>Email</dt><dd>{{ $resident->email ?: '-' }}</dd>
                <dt>Alamat KTP</dt><dd>{{ $resident->address_on_id ?: '-' }}</dd>
            </dl>
        </section>
    </div>
@else
    <section class="card">
        <div class="empty-state">Akun Anda belum terhubung dengan data warga. Silakan hubungi admin RT/RW.</div>
    </section>
@endif
@endsection
