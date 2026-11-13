@extends('layouts.app')

@section('title', 'Pengumuman / Informasi')
@section('subtitle', 'Informasi kegiatan, rapat, iuran, dan berita lingkungan.')

@section('topbar')
    @if(auth()->user()->isAdmin())
        <a class="btn" href="{{ route('announcements.create') }}">Tambah Pengumuman</a>
    @endif
@endsection

@section('content')
<section class="card">
    <div class="toolbar">
        <form class="filter-form" method="GET">
            <input name="search" value="{{ request('search') }}" placeholder="Cari pengumuman">
            <button class="btn secondary" type="submit">Filter</button>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($announcements as $announcement)
                <tr>
                    <td><strong>{{ $announcement->title }}</strong><div class="muted">Oleh {{ optional($announcement->author)->name ?: '-' }}</div></td>
                    <td>{{ $announcement->category }}</td>
                    <td><span class="badge {{ $announcement->is_published ? 'success' : 'warning' }}">{{ $announcement->is_published ? 'Terbit' : 'Draft' }}</span></td>
                    <td>{{ optional($announcement->published_at)->format('d M Y') ?: '-' }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn secondary small" href="{{ route('announcements.show', $announcement) }}">Detail</a>
                            @if(auth()->user()->isAdmin())
                                <a class="btn secondary small" href="{{ route('announcements.edit', $announcement) }}">Edit</a>
                                <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger small" type="submit">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty-state">Belum ada pengumuman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $announcements->links() }}</div>
</section>
@endsection
