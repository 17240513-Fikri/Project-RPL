@extends('layouts.app')

@section('title', 'Tambah Data Warga')
@section('subtitle', 'Masukkan data kependudukan warga secara lengkap.')

@section('content')
<section class="card">
    <form method="POST" action="{{ route('residents.store') }}">
        @include('residents._form')
    </form>
</section>
@endsection
