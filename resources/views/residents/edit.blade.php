@extends('layouts.app')

@section('title', 'Edit Data Warga')
@section('subtitle', $resident->name)

@section('content')
<section class="card">
    <form method="POST" action="{{ route('residents.update', $resident) }}">
        @include('residents._form')
    </form>
</section>
@endsection
