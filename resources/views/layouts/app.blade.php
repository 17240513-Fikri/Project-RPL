<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal RT/RW')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="@auth app-body @else public-body @endauth">
@auth
    <div class="shell">
        <aside class="sidebar">
            <div class="brand-row">
                <a class="brand" href="{{ route('dashboard') }}">
                    <span class="brand-mark">RT</span>
                    <span class="brand-copy">
                        <span class="brand-title">Portal RT/RW</span>
                        <span class="brand-subtitle">Administrasi warga</span>
                    </span>
                </a>
                <button class="icon-btn nav-toggle sidebar-close" type="button" aria-label="Tutup menu">
                    <span class="close-lines"></span>
                </button>
            </div>

            <nav>
                <div class="nav-label">Menu</div>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon">#</span>Dashboard</a>
                @if(auth()->user()->isAdmin())
                    <a class="nav-link {{ request()->routeIs('residents.*') ? 'active' : '' }}" href="{{ route('residents.index') }}"><span class="nav-icon">W</span>Data Warga</a>
                    <a class="nav-link {{ request()->routeIs('households.*') ? 'active' : '' }}" href="{{ route('households.index') }}"><span class="nav-icon">K</span>Kepala Keluarga</a>
                    <a class="nav-link {{ request()->routeIs('cash.*') ? 'active' : '' }}" href="{{ route('cash.index') }}"><span class="nav-icon">Rp</span>Kas RT/RW</a>
                @else
                    <a class="nav-link {{ request()->routeIs('residents.profile') ? 'active' : '' }}" href="{{ route('residents.profile') }}"><span class="nav-icon">P</span>Profil Saya</a>
                @endif
                <a class="nav-link {{ request()->routeIs('letters.*') ? 'active' : '' }}" href="{{ route('letters.index') }}"><span class="nav-icon">S</span>Surat Keterangan</a>
                <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}" href="{{ route('announcements.index') }}"><span class="nav-icon">I</span>Pengumuman</a>
            </nav>

            <div class="sidebar-footer">
                <strong>{{ auth()->user()->name }}</strong>
                <div class="user-meta">{{ auth()->user()->email }}</div>
                <div style="margin: 10px 0;"><span class="badge {{ auth()->user()->role === 'admin' ? 'admin' : '' }}">{{ strtoupper(auth()->user()->role) }}</span></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn secondary small" type="submit">Keluar</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <header class="topbar">
                <button class="icon-btn nav-toggle" type="button" aria-label="Buka menu">
                    <span class="menu-lines"></span>
                </button>
                <div class="topbar-copy">
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    @hasSection('subtitle')
                        <p class="page-subtitle">@yield('subtitle')</p>
                    @endif
                </div>
                @yield('topbar')
            </header>

            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert error">
                    <strong>Periksa kembali input berikut:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
@else
    @yield('content')
@endauth
<script>
    (function () {
        const body = document.body;
        const toggles = document.querySelectorAll('.nav-toggle');

        if (localStorage.getItem('sidebar-collapsed') === '1') {
            body.classList.add('sidebar-collapsed');
        }

        toggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                if (window.matchMedia('(max-width: 980px)').matches) {
                    body.classList.toggle('nav-open');
                    return;
                }

                body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', body.classList.contains('sidebar-collapsed') ? '1' : '0');
            });
        });
    })();
</script>
</body>
</html>
