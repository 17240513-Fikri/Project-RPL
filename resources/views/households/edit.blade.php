@extends('layouts.app')

@section('title', 'Edit Data KK')
@section('subtitle', $household->family_card_number)

@section('content')
<section class="card">
    <form method="POST" action="{{ route('households.update', $household) }}">
        @include('households._form')
    </form>
</section>
@endsection
