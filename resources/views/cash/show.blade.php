@extends('layouts.app')

@section('title', 'Detail Transaksi Kas')
@section('subtitle', $cashTransaction->transaction_code)

@section('topbar')
    <div class="actions">
        <a class="btn secondary" href="{{ route('cash.index') }}">Kembali</a>
        <a class="btn" href="{{ route('cash.edit', $cashTransaction) }}">Edit</a>
    </div>
@endsection

@section('content')
<section class="card">
    <dl class="detail-list">
        <dt>Kode</dt><dd>{{ $cashTransaction->transaction_code }}</dd>
        <dt>Jenis</dt><dd><span class="badge {{ $cashTransaction->type }}">{{ ucwords($cashTransaction->type) }}</span></dd>
        <dt>Kategori</dt><dd>{{ $cashTransaction->category }}</dd>
        <dt>Nominal</dt><dd>Rp {{ number_format($cashTransaction->amount, 0, ',', '.') }}</dd>
        <dt>Tanggal</dt><dd>{{ $cashTransaction->transaction_date->format('d M Y') }}</dd>
        <dt>Metode Bayar</dt><dd>{{ $cashTransaction->payment_method ?: '-' }}</dd>
        <dt>Referensi</dt><dd>{{ $cashTransaction->reference ?: '-' }}</dd>
        <dt>Dicatat oleh</dt><dd>{{ optional($cashTransaction->recorder)->name ?: '-' }}</dd>
        <dt>Keterangan</dt><dd>{{ $cashTransaction->description }}</dd>
    </dl>
</section>
@endsection
