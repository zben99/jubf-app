<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SENAC-UB 2026 — Administration</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          onerror="this.onerror=null;this.href='{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}'">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --cenou-red:      #c0392b;
            --cenou-red-dark: #922b21;
            --sidebar-w:      240px;
            --topbar-h:       62px;
        }
        body { background: #f0f2f5; font-family: 'Figtree', 'Segoe UI', sans-serif; }

        /* ── Topbar ── */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1040;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 3px solid var(--cenou-red);
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            display: flex; align-items: center; padding: 0 20px; gap: 14px;
        }
        .topbar .logo-img { height: 42px; width: auto; object-fit: contain; }
        .topbar .brand-title   { font-size: .85rem; font-weight: 800; color: var(--cenou-red); line-height: 1.2; }
        .topbar .brand-sub     { font-size: .68rem; color: #999; line-height: 1.2; }
        .topbar .sidebar-toggle {
            background: none; border: none; cursor: pointer;
            color: #666; font-size: 1.1rem; padding: 6px 8px;
            display: none;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: var(--topbar-h); left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: #1c2333;
            overflow-y: auto; z-index: 1030;
            transition: transform .25s ease;
            padding-bottom: 24px;
        }
        .sidebar .nav-section {
            padding: 20px 18px 6px;
            font-size: .6rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.8px;
            color: #556;
        }
        .sidebar .nav-link {
            display: flex; align-items: center; gap: 11px;
            color: #b0b8cc; padding: 10px 20px;
            font-size: .84rem; font-weight: 500;
            border-left: 3px solid transparent;
            transition: all .18s;
            text-decoration: none;
        }
        .sidebar .nav-link i { width: 17px; text-align: center; font-size: .9rem; }
        .sidebar .nav-link:hover  { background: rgba(255,255,255,.06); color: #fff; }
        .sidebar .nav-link.active {
            background: rgba(192,57,43,.18);
            color: #e8a09a;
            border-left-color: var(--cenou-red);
            font-weight: 600;
        }
        .sidebar .sidebar-footer {
            padding: 16px 20px 0;
            border-top: 1px solid #2c3347;
            margin-top: 16px;
        }

        /* ── Main ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            min-height: calc(100vh - var(--topbar-h));
            display: flex; flex-direction: column;
        }
        .page-header {
            background: #fff;
            border-bottom: 1px solid #e3e6ea;
            padding: 16px 28px;
        }
        .page-header h2 { font-size: 1.15rem; font-weight: 700; color: #1c2333; margin: 0; }
        .page-header .breadcrumb { margin: 0; font-size: .8rem; }
        .page-content { padding: 24px 28px; flex: 1; }

        /* ── Cards admin ── */
        .card-admin { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
        .card-admin .card-header {
            background: var(--cenou-red); color: #fff;
            border-radius: 10px 10px 0 0 !important;
            padding: 14px 20px; font-weight: 600;
        }
        .card-admin .card-header.ch-neutral {
            background: #fff; color: #1c2333;
            border-bottom: 2px solid #f0f2f5;
        }

        /* ── Stat cards ── */
        .stat-card { border: none; border-radius: 10px; overflow: hidden; }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
        }

        /* ── Badges statut ── */
        .badge-artiste      { background: #6f42c1; }
        .badge-sportif      { background: #0d6efd; }
        .badge-encadreur    { background: #198754; }
        .badge-organisateur { background: #fd7e14; }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar .sidebar-toggle { display: block; }
        }
    </style>
</head>
<body>

    {{-- ── TOPBAR ── --}}
    <header class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset('images/logo_cenou.jpg') }}" alt="CENOU" class="logo-img">
            <div class="d-none d-sm-block">
                <div class="brand-title">SENAC-UB 2026</div>
                <div class="brand-sub">Centre National des Œuvres Universitaires</div>
            </div>
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="d-none d-md-flex align-items-center gap-2 text-muted" style="font-size:.82rem;">
                <i class="fas fa-circle text-success" style="font-size:.5rem;"></i>
                {{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    <span class="d-none d-md-inline">Déconnexion</span>
                </button>
            </form>
        </div>
    </header>

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar" id="adminSidebar">
        <div class="nav-section">Navigation</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">
                <i class="fas fa-chart-pie"></i> Tableau de bord
            </a>
        </nav>

        <div class="nav-section">Gestion</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('etudiants.*') ? 'active' : '' }}"
               href="{{ route('etudiants.index') }}">
                <i class="fas fa-users"></i> Candidats
            </a>
            <a class="nav-link {{ request()->routeIs('universities.*') ? 'active' : '' }}"
               href="{{ route('universities.index') }}">
                <i class="fas fa-university"></i> Universités
            </a>
            <a class="nav-link {{ request()->routeIs('disciplines.*') ? 'active' : '' }}"
               href="{{ route('disciplines.index') }}">
                <i class="fas fa-music"></i> Disciplines
            </a>
        </nav>

        @if(Auth::user()->isAdmin())
        <div class="nav-section">Export</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('badges.*') ? 'active' : '' }}"
               href="{{ route('badges.export') }}">
                <i class="fas fa-file-pdf"></i> Téléchargement badges
            </a>
        </nav>
        @endif

        <div class="sidebar-footer mt-auto">
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="fas fa-external-link-alt"></i> Voir le site public
            </a>
        </div>
    </aside>

    {{-- ── CONTENU PRINCIPAL ── --}}
    <div class="main-wrapper">
        @isset($header)
            <div class="page-header">
                {{ $header }}
            </div>
        @endisset

        <div class="page-content">
            {{ $slot }}
        </div>
    </div>

    {{-- Overlay mobile --}}
    <div id="sidebarOverlay" onclick="closeSidebar()"
         style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:1029;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            onerror="this.onerror=null;this.src='{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}'"></script>
    <script>
        const sidebar  = document.getElementById('adminSidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const toggle   = document.getElementById('sidebarToggle');

        toggle?.addEventListener('click', () => {
            const open = sidebar.classList.toggle('open');
            overlay.style.display = open ? 'block' : 'none';
        });

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.style.display = 'none';
        }
    </script>
</body>
</html>
