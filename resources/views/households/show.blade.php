@extends('layouts.app')

@section('title', 'Detail Kartu Keluarga')
@section('subtitle', $household->family_card_number)

@section('topbar')
    <div class="actions">
        <a class="btn secondary" href="{{ route('households.index') }}">Kembali</a>
        <a class="btn" href="{{ route('households.edit', $household) }}">Edit</a>
    </div>
@endsection

@section('content')
<div class="grid grid-2">
    <section class="card">
        <h2>Informasi KK</h2>
        <dl class="detail-list">
            <dt>Nomor KK</dt><dd>{{ $household->family_card_number }}</dd>
            <dt>Kepala Keluarga</dt><dd>{{ optional($household->head)->name ?: '-' }}</dd>
            <dt>Alamat</dt><dd>{{ $household->address }}</dd>
            <dt>RT/RW</dt><dd>{{ $household->rt }}/{{ $household->rw }}</dd>
            <dt>Wilayah</dt><dd>{{ $household->kelurahan ?: '-' }}, {{ $household->kecamatan ?: '-' }}, {{ $household->city ?: '-' }}</dd>
            <dt>Status Rumah</dt><dd>{{ str_replace('_', ' ', ucwords($household->home_status, '_')) }}</dd>
            <dt>Status Ekonomi</dt><dd>{{ str_replace('_', ' ', ucwords($household->economic_status, '_')) }}</dd>
        </dl>
    </section>
    <section class="card">
        <h2>Catatan</h2>
        <p>{{ $household->notes ?: 'Tidak ada catatan.' }}</p>
    </section>
</div>

<section class="card" style="margin-top: 18px;">
    <h2>Anggota Keluarga</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>NIK</th><th>Nama</th><th>Status Keluarga</th><th>Status Warga</th></tr></thead>
            <tbody>
            @forelse($household->residents as $resident)
                <tr>
                    <td>{{ $resident->nik }}</td>
                    <td><a href="{{ route('residents.show', $resident) }}">{{ $resident->name }}</a></td>
                    <td>{{ $resident->family_status ?: '-' }}</td>
                    <td><span class="badge {{ $resident->resident_status === 'aktif' ? 'success' : 'warning' }}">{{ ucwords($resident->resident_status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty-state">Belum ada anggota keluarga.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
