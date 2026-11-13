@extends('layouts.app')

@section('content')
<div class="public-page">
    <div class="public-shell">
        <nav class="public-nav">
            <a href="/"><strong>Portal RT/RW</strong></a>
            <div class="actions">
                <a class="btn secondary" href="{{ route('register') }}">Daftar Warga</a>
                <a class="btn secondary" href="/">Beranda</a>
            </div>
        </nav>

        <section class="public-hero">
            <div>
                <h1>Masuk ke Dashboard</h1>
                <p>Gunakan akun admin untuk mengelola semua data atau akun warga untuk mengajukan surat dan melihat informasi lingkungan.</p>
            </div>

            <div class="card" style="color: var(--text);">
                @if($errors->any())
                    <div class="alert error">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('login.store') }}" class="grid">
                    @csrf
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required>
                    </div>
                    <label style="display: flex; gap: 8px; align-items: center;">
                        <input type="checkbox" name="remember" value="1"> Ingat saya
                    </label>
                    <button class="btn" type="submit">Masuk</button>
                    <p class="muted">Belum punya akun warga? <a href="{{ route('register') }}"><strong>Daftar di sini</strong></a>.</p>
                    <p class="muted">Akun demo: admin@rtrw.local / password atau warga@rtrw.local / password</p>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
