@extends('layouts.app')

@section('title', 'Manajemen Data Warga')
@section('subtitle', 'Kelola NIK, domisili, status keluarga, dan informasi kependudukan.')

@section('topbar')
    <a class="btn" href="{{ route('residents.create') }}">Tambah Warga</a>
@endsection

@section('content')
<section class="card">
    <div class="toolbar">
        <form class="filter-form" method="GET">
            <input name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, telepon">
            <select name="status">
                <option value="">Semua status</option>
                @foreach(['aktif', 'sementara', 'pindah', 'meninggal'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucwords($status) }}</option>
                @endforeach
            </select>
            <button class="btn secondary" type="submit">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>KK</th>
                <th>Status</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($residents as $resident)
                <tr>
                    <td>{{ $resident->nik }}</td>
                    <td><strong>{{ $resident->name }}</strong><div class="muted">{{ $resident->gender }} - {{ $resident->occupation ?: '-' }}</div></td>
                    <td>{{ optional($resident->household)->family_card_number ?: '-' }}</td>
                    <td><span class="badge {{ $resident->resident_status === 'aktif' ? 'success' : 'warning' }}">{{ ucwords($resident->resident_status) }}</span></td>
                    <td>{{ $resident->phone ?: '-' }}<div class="muted">{{ $resident->email ?: '' }}</div></td>
                    <td>
                        <div class="actions">
                            <a class="btn secondary small" href="{{ route('residents.show', $resident) }}">Detail</a>
                            <a class="btn secondary small" href="{{ route('residents.edit', $resident) }}">Edit</a>
                            <form method="POST" action="{{ route('residents.destroy', $resident) }}" onsubmit="return confirm('Hapus data warga ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger small" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">Belum ada data warga.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $residents->links() }}</div>
</section>
@endsection
