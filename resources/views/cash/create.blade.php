@extends('layouts.app')

@section('title', 'Tambah Transaksi Kas')
@section('subtitle', 'Catat pemasukan atau pengeluaran kas RT/RW.')

@section('content')
<section class="card">
    <form method="POST" action="{{ route('cash.store') }}">
        @include('cash._form')
    </form>
</section>
@endsection
