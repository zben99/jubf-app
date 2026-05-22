<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SENAC-UB 2026 — Connexion</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --cenou-red: #c0392b; --cenou-red-dark: #922b21; }

        html, body { height: 100%; margin: 0; }
        body {
            font-family: 'Figtree', 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex; align-items: stretch; min-height: 100vh;
        }

        /* Panneau gauche */
        .login-left {
            width: 45%;
            background: linear-gradient(160deg, #1c2333 0%, #2c3e50 60%, #922b21 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 48px 40px; text-align: center; color: #fff;
        }
        .login-left img { height: 110px; width: auto; margin-bottom: 24px; }
        .login-left .compet-title {
            font-size: 1.5rem; font-weight: 800; line-height: 1.3;
            color: #fff; margin-bottom: 8px;
        }
        .login-left .compet-sub {
            font-size: .85rem; color: rgba(255,255,255,.65);
            margin-bottom: 20px; line-height: 1.5;
        }
        .login-left .edition-pill {
            display: inline-block;
            background: var(--cenou-red); color: #fff;
            font-weight: 700; font-size: .8rem;
            padding: 5px 20px; border-radius: 20px;
        }
        .login-left .divider {
            width: 50px; height: 3px;
            background: rgba(255,255,255,.2); border-radius: 2px;
            margin: 24px auto;
        }
        .login-left .features { list-style: none; padding: 0; margin: 0; text-align: left; }
        .login-left .features li {
            display: flex; align-items: center; gap: 10px;
            font-size: .82rem; color: rgba(255,255,255,.7); margin-bottom: 10px;
        }
        .login-left .features li i { color: var(--cenou-red); font-size: .9rem; width: 16px; }

        /* Panneau droit */
        .login-right {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 40px 32px;
        }
        .login-card {
            width: 100%; max-width: 420px;
            background: #fff; border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,.10);
            padding: 40px 36px;
        }
        .login-card .card-icon {
            width: 56px; height: 56px; border-radius: 14px;
            background: var(--cenou-red); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin: 0 auto 20px;
        }
        .login-card h2 {
            font-size: 1.3rem; font-weight: 800; color: #1c2333;
            text-align: center; margin-bottom: 6px;
        }
        .login-card .subtitle {
            text-align: center; color: #888; font-size: .82rem; margin-bottom: 28px;
        }
        .login-card .form-label { font-weight: 600; font-size: .85rem; color: #444; }
        .login-card .form-control {
            border-radius: 8px; border: 1.5px solid #e3e6ea;
            padding: 10px 14px; font-size: .9rem;
            transition: border-color .2s;
        }
        .login-card .form-control:focus {
            border-color: var(--cenou-red);
            box-shadow: 0 0 0 3px rgba(192,57,43,.12);
        }
        .btn-login {
            background: var(--cenou-red); border: none; color: #fff;
            width: 100%; padding: 12px; border-radius: 8px;
            font-weight: 700; font-size: .95rem;
            transition: background .2s, transform .1s;
        }
        .btn-login:hover { background: var(--cenou-red-dark); color: #fff; transform: translateY(-1px); }

        @media (max-width: 767px) {
            body { flex-direction: column; }
            .login-left {
                width: 100%; padding: 30px 24px;
                background: linear-gradient(135deg, #1c2333, #922b21);
            }
            .login-left img { height: 70px; }
            .login-left .compet-title { font-size: 1.1rem; }
            .login-left .features { display: none; }
            .login-right { padding: 24px 16px; }
        }
    </style>
</head>
<body>

    {{-- Panneau gauche : branding --}}
    <div class="login-left">
        <img src="{{ asset('images/logo_cenou.jpg') }}" alt="CENOU">
        <div class="compet-title">Semaine Nationale des Arts<br>et de la Culture des Universités<br>du Burkina</div>
        <div class="compet-sub">Centre National des Œuvres Universitaires</div>
        <span class="edition-pill">SENAC-UB &mdash; Édition 2026</span>
        <div class="divider"></div>
        <ul class="features">
            <li><i class="fas fa-users"></i> Gestion des candidats et inscriptions</li>
            <li><i class="fas fa-university"></i> 26 universités participantes</li>
            <li><i class="fas fa-music"></i> 18 disciplines artistiques & sportives</li>
            <li><i class="fas fa-id-badge"></i> Génération de badges PDF</li>
            <li><i class="fas fa-chart-bar"></i> Tableau de bord statistique</li>
        </ul>
    </div>

    {{-- Panneau droit : formulaire --}}
    <div class="login-right">
        <div class="login-card">
            <div class="card-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h2>Espace Administration</h2>
            <div class="subtitle">Connectez-vous pour accéder à la plateforme</div>

            {{ $slot }}

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Retour au site public
                </a>
            </div>
        </div>

        <div class="text-center mt-4 text-muted" style="font-size:.75rem;">
            &copy; 2026 CENOU — Tous droits réservés
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
