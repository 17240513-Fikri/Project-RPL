@extends('layouts.app')

@section('title', 'Edit Pengumuman')
@section('subtitle', $announcement->title)

@section('content')
<section class="card">
    <form method="POST" action="{{ route('announcements.update', $announcement) }}">
        @include('announcements._form')
    </form>
</section>
@endsection
