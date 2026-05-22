<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscriptions fermées – SENAC-UB 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        header {
            background: #fff;
            border-bottom: 4px solid #c0392b;
            padding: 16px 40px;
            display: flex; flex-direction: column;
            align-items: center; text-align: center; gap: 8px;
        }
        header img { height: 90px; }
        .brand-title { font-size: 1.1rem; font-weight: 800; color: #c0392b; }
        .brand-sub   { font-size: .8rem; color: #888; }
        main {
            flex: 1; display: flex;
            align-items: center; justify-content: center;
            padding: 40px 20px;
        }
        .closed-card {
            background: #fff; border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            padding: 48px 40px; text-align: center;
            max-width: 520px; width: 100%;
        }
        .icon-circle {
            width: 80px; height: 80px; border-radius: 50%;
            background: #fdecea; display: flex;
            align-items: center; justify-content: center;
            margin: 0 auto 24px; font-size: 2rem; color: #c0392b;
        }
        footer {
            background: #fff; border-top: 1px solid #e8ecf1;
            padding: 16px; text-align: center;
            font-size: .8rem; color: #aaa;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo_cenou.jpg') }}" alt="CENOU">
        <div class="brand-title">Semaine Nationale des Arts et de la Culture des Universités du Burkina</div>
        <div class="brand-sub">SENAC-UB &mdash; Édition 2026</div>
    </header>

    <main>
        <div class="closed-card">
            <div class="icon-circle">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="fw-bold mb-2" style="color:#1c2333;">Inscriptions fermées</h2>
            <p class="text-muted mb-4" style="font-size:.95rem;">
                La période d'inscription à la <strong>SENAC-UB 2026</strong> est actuellement
                fermée. Veuillez contacter l'administration pour plus d'informations.
            </p>
            <a href="{{ url('/') }}" class="btn px-5 py-2 fw-semibold text-white"
               style="background:#c0392b; border-radius:8px;">
                <i class="fas fa-arrow-left me-2"></i> Retour à l'accueil
            </a>
        </div>
    </main>

    <footer>&copy; 2026 CENOU — Tous droits réservés</footer>
</body>
</html>
