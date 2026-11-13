@extends('layouts.app')

@section('title', 'Edit Transaksi Kas')
@section('subtitle', $cashTransaction->transaction_code)

@section('content')
<section class="card">
    <form method="POST" action="{{ route('cash.update', $cashTransaction) }}">
        @include('cash._form')
    </form>
</section>
@endsection
