@extends('layouts.app')

@section('title', 'Kas RT/RW')
@section('subtitle', 'Catat pemasukan, pengeluaran, saldo, dan histori transaksi.')

@section('topbar')
    <a class="btn" href="{{ route('cash.create') }}">Tambah Transaksi</a>
@endsection

@section('content')
<div class="grid grid-3" style="margin-bottom: 18px;">
    <div class="stat-card"><div class="stat-label">Pemasukan</div><div class="stat-value">Rp {{ number_format($income, 0, ',', '.') }}</div></div>
    <div class="stat-card"><div class="stat-label">Pengeluaran</div><div class="stat-value">Rp {{ number_format($expense, 0, ',', '.') }}</div></div>
    <div class="stat-card"><div class="stat-label">Saldo</div><div class="stat-value">Rp {{ number_format($balance, 0, ',', '.') }}</div></div>
</div>

<section class="card">
    <div class="toolbar">
        <form class="filter-form" method="GET">
            <input name="search" value="{{ request('search') }}" placeholder="Cari kategori, kode, keterangan">
            <select name="type">
                <option value="">Semua jenis</option>
                <option value="pemasukan" @selected(request('type') === 'pemasukan')>Pemasukan</option>
                <option value="pengeluaran" @selected(request('type') === 'pengeluaran')>Pengeluaran</option>
            </select>
            <button class="btn secondary" type="submit">Filter</button>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Kode</th><th>Jenis</th><th>Kategori</th><th>Nominal</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_code }}</td>
                    <td><span class="badge {{ $transaction->type }}">{{ ucwords($transaction->type) }}</span></td>
                    <td><strong>{{ $transaction->category }}</strong><div class="muted">{{ $transaction->description }}</div></td>
                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn secondary small" href="{{ route('cash.show', $transaction) }}">Detail</a>
                            <a class="btn secondary small" href="{{ route('cash.edit', $transaction) }}">Edit</a>
                            <form method="POST" action="{{ route('cash.destroy', $transaction) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger small" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">Belum ada transaksi kas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $transactions->links() }}</div>
</section>
@endsection
