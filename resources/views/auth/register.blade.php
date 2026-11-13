@extends('layouts.app')

@section('content')
<div class="public-page">
    <div class="public-shell">
        <nav class="public-nav">
            <a href="/"><strong>Portal RT/RW</strong></a>
            <div class="actions">
                <a class="btn secondary" href="{{ route('login') }}">Masuk</a>
                <a class="btn secondary" href="/">Beranda</a>
            </div>
        </nav>

        <section class="public-hero">
            <div>
                <h1>Registrasi Akun Warga</h1>
                <p>Daftar menggunakan NIK dan nomor KK yang sudah tercatat di database RT/RW. Setelah cocok, akun warga langsung aktif dan terhubung ke profil Anda.</p>
            </div>

            <div class="card" style="color: var(--text);">
                @if($errors->any())
                    <div class="alert error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="grid">
                    @csrf
                    <div class="field">
                        <label for="nik">NIK</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" maxlength="20" required autofocus>
                    </div>
                    <div class="field">
                        <label for="family_card_number">Nomor KK</label>
                        <input id="family_card_number" name="family_card_number" value="{{ old('family_card_number') }}" maxlength="20" required>
                    </div>
                    <div class="field">
                        <label for="email">Email Login</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" minlength="8" required>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required>
                    </div>
                    <button class="btn" type="submit">Daftar dan Masuk</button>
                    <p class="muted">Jika NIK belum terdaftar, minta admin menambahkan data warga terlebih dahulu.</p>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
