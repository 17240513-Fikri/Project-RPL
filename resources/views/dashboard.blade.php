@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan operasional RT/RW, surat, kas, dan informasi terbaru.')

@section('content')
<div class="grid grid-4">
    <div class="stat-card">
        <div class="stat-icon">W</div>
        <div class="stat-label">Warga</div>
        <div class="stat-value">{{ number_format($stats['residents']) }}</div>
        <div class="stat-note">Total data warga</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">KK</div>
        <div class="stat-label">Kartu Keluarga</div>
        <div class="stat-value">{{ number_format($stats['households']) }}</div>
        <div class="stat-note">Total KK terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">S</div>
        <div class="stat-label">Surat Aktif</div>
        <div class="stat-value">{{ number_format($stats['letters_pending']) }}</div>
        <div class="stat-note">Diajukan atau diproses</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">Rp</div>
        <div class="stat-label">Saldo Kas</div>
        <div class="stat-value">Rp {{ number_format($stats['cash_balance'], 0, ',', '.') }}</div>
        <div class="stat-note">Pemasukan dikurangi pengeluaran</div>
    </div>
</div>

<div class="grid grid-2" style="margin-top: 18px;">
    <section class="card">
        <h2>Kas 6 Bulan Terakhir</h2>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Bulan</th><th>Pemasukan</th><th>Pengeluaran</th></tr></thead>
                <tbody>
                @foreach($monthlyCash as $month)
                    @php($max = max($month['income'], $month['expense'], 1))
                    <tr>
                        <td>{{ $month['label'] }}</td>
                        <td>
                            Rp {{ number_format($month['income'], 0, ',', '.') }}
                            <div class="bar-track"><div class="bar-fill" style="width: {{ ($month['income'] / $max) * 100 }}%"></div></div>
                        </td>
                        <td>
                            Rp {{ number_format($month['expense'], 0, ',', '.') }}
                            <div class="bar-track"><div class="bar-fill" style="width: {{ ($month['expense'] / $max) * 100 }}%; background: var(--accent);"></div></div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="card">
        <h2>Profil Wilayah</h2>
        @if($profile)
            <dl class="detail-list">
                <dt>Nama</dt><dd>{{ $profile->name }}</dd>
                <dt>RT/RW</dt><dd>{{ $profile->rt }}/{{ $profile->rw }}</dd>
                <dt>Ketua</dt><dd>{{ $profile->chairman_name ?: '-' }}</dd>
                <dt>Sekretaris</dt><dd>{{ $profile->secretary_name ?: '-' }}</dd>
                <dt>Bendahara</dt><dd>{{ $profile->treasurer_name ?: '-' }}</dd>
                <dt>Alamat</dt><dd>{{ $profile->address }}</dd>
            </dl>
        @else
            <div class="empty-state">Profil wilayah belum diisi.</div>
        @endif
    </section>
</div>

<div class="grid grid-2" style="margin-top: 18px;">
    <section class="card">
        <div class="toolbar">
            <h2>Pengajuan Surat Terbaru</h2>
            <a class="btn small" href="{{ route('letters.create') }}">Ajukan Surat</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Warga</th><th>Jenis</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($latestLetters as $letter)
                    <tr>
                        <td><a href="{{ route('letters.show', $letter) }}">{{ $letter->resident->name }}</a></td>
                        <td>{{ $letter->type->name }}</td>
                        <td><span class="badge {{ $letter->status }}">{{ ucwords($letter->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty-state">Belum ada pengajuan surat.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="card">
        <div class="toolbar">
            <h2>Pengumuman Terbaru</h2>
            <a class="btn secondary small" href="{{ route('announcements.index') }}">Lihat Semua</a>
        </div>
        <div class="grid">
            @forelse($latestAnnouncements as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}">
                    <strong>{{ $announcement->title }}</strong>
                    <div class="muted">{{ $announcement->category }} - {{ optional($announcement->published_at)->format('d M Y') }}</div>
                </a>
            @empty
                <div class="empty-state">Belum ada pengumuman.</div>
            @endforelse
        </div>
    </section>
</div>
@endsection
