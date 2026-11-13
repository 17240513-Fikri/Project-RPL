@extends('layouts.app')

@section('title', 'Tambah Pengumuman')
@section('subtitle', 'Publikasikan informasi untuk warga.')

@section('content')
<section class="card">
    <form method="POST" action="{{ route('announcements.store') }}">
        @include('announcements._form')
    </form>
</section>
@endsection
