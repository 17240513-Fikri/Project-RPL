@extends('layouts.app')

@section('content')
<div class="public-page">
    <div class="public-shell">
        <nav class="public-nav">
            <strong>Portal Administrasi</strong>
            <div class="actions">
                <a class="btn secondary" href="{{ route('register') }}">Daftar Akun</a>
                <a class="btn secondary" href="{{ route('login') }}">Masuk</a>
            </div>
        </nav>

        <section class="public-hero">
            <div>
                <h1>Portal Administrasi</h1>
                <p>Rukun Warganya, Maju Lingkungannya</p>
                <div style="margin-top: 28px;">
                    <a class="btn" href="{{ route('login') }}">Buka Dashboard</a>
                    <a class="btn secondary" href="{{ route('register') }}" style="margin-left: 8px;">Daftar Akun</a>
                </div>
            </div>
            <div class="feature-grid">
                <div class="feature-tile"><strong>Data Warga</strong><span>NIK, status domisili, pekerjaan, kontak, dan riwayat.</span></div>
                <div class="feature-tile"><strong>Kepala Keluarga</strong><span>Nomor KK, alamat, kepala keluarga, dan anggota.</span></div>
                <div class="feature-tile"><strong>Surat Keterangan</strong><span>Domisili, tidak mampu, pengantar KTP, dan lainnya.</span></div>
                <div class="feature-tile"><strong>Kas RT/RW</strong><span>Pemasukan, pengeluaran, saldo, dan histori transaksi.</span></div>
                <div class="feature-tile"><strong>Pengumuman</strong><span>Informasi kegiatan dan berita lingkungan.</span></div>
            </div>
        </section>
    </div>
</div>
@endsection
