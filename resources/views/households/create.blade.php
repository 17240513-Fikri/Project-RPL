@extends('layouts.app')

@section('title', 'Tambah Data KK')
@section('subtitle', 'Masukkan informasi kartu keluarga dan alamat domisili.')

@section('content')
<section class="card">
    <form method="POST" action="{{ route('households.store') }}">
        @include('households._form')
    </form>
</section>
@endsection
