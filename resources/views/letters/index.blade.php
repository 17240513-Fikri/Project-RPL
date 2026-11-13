@extends('layouts.app')

@section('title', 'Surat Keterangan')
@section('subtitle', 'Pengajuan dan pemrosesan surat domisili, tidak mampu, pengantar KTP, dan lainnya.')

@section('topbar')
    <a class="btn" href="{{ route('letters.create') }}">Ajukan Surat</a>
@endsection

@section('content')
<section class="card">
    <div class="toolbar">
        <form class="filter-form" method="GET">
            <select name="status">
                <option value="">Semua status</option>
                @foreach(['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucwords($status) }}</option>
                @endforeach
            </select>
            <button class="btn secondary" type="submit">Filter</button>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>No Surat</th><th>Jenis</th><th>Warga</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($letters as $letter)
                <tr>
                    <td>{{ $letter->request_number ?: '-' }}</td>
                    <td><strong>{{ $letter->type->name }}</strong><div class="muted">{{ $letter->purpose }}</div></td>
                    <td>{{ $letter->resident->name }}<div class="muted">{{ $letter->resident->nik }}</div></td>
                    <td><span class="badge {{ $letter->status }}">{{ ucwords($letter->status) }}</span></td>
                    <td>{{ $letter->created_at->format('d M Y') }}</td>
                    <td><a class="btn secondary small" href="{{ route('letters.show', $letter) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">Belum ada pengajuan surat.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $letters->links() }}</div>
</section>
@endsection
