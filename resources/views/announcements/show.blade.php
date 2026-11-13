@extends('layouts.app')

@section('title', $announcement->title)
@section('subtitle', $announcement->category . ' - ' . (optional($announcement->published_at)->format('d M Y') ?: 'Draft'))

@section('topbar')
    <div class="actions">
        <a class="btn secondary" href="{{ route('announcements.index') }}">Kembali</a>
        @if(auth()->user()->isAdmin())
            <a class="btn" href="{{ route('announcements.edit', $announcement) }}">Edit</a>
        @endif
    </div>
@endsection

@section('content')
<article class="card">
    <p class="muted">Ditulis oleh {{ optional($announcement->author)->name ?: '-' }}</p>
    <div style="white-space: pre-line; line-height: 1.8;">{{ $announcement->content }}</div>
</article>
@endsection
