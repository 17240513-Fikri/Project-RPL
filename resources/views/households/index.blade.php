@extends('layouts.app')

@section('title', 'Manajemen Kepala Keluarga')
@section('subtitle', 'Kelola nomor KK, kepala keluarga, alamat, dan anggota keluarga.')

@section('topbar')
    <a class="btn" href="{{ route('households.create') }}">Tambah KK</a>
@endsection

@section('content')
<section class="card">
    <div class="toolbar">
        <form class="filter-form" method="GET">
            <input name="search" value="{{ request('search') }}" placeholder="Cari nomor KK, alamat, kepala keluarga">
            <button class="btn secondary" type="submit">Filter</button>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Nomor KK</th><th>Kepala Keluarga</th><th>Alamat</th><th>Anggota</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($households as $household)
                <tr>
                    <td><strong>{{ $household->family_card_number }}</strong></td>
                    <td>{{ optional($household->head)->name ?: '-' }}</td>
                    <td>{{ $household->address }}<div class="muted">RT {{ $household->rt }} / RW {{ $household->rw }}</div></td>
                    <td>{{ $household->residents->count() }} orang</td>
                    <td>
                        <div class="actions">
                            <a class="btn secondary small" href="{{ route('households.show', $household) }}">Detail</a>
                            <a class="btn secondary small" href="{{ route('households.edit', $household) }}">Edit</a>
                            <form method="POST" action="{{ route('households.destroy', $household) }}" onsubmit="return confirm('Hapus data KK ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger small" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty-state">Belum ada data KK.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $households->links() }}</div>
</section>
@endsection
