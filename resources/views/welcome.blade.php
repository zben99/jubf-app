<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>SENAC-UB 2026 - Inscriptions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background: #fff;
      padding: 24px 40px;
      border-bottom: 4px solid #c0392b;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    header img {
      height: 100px;
      width: auto;
    }
    .header-text h2 {
      font-size: 0.8em;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .header-text h1 {
      font-size: 1.4em;
      color: #c0392b;
      font-weight: 800;
      line-height: 1.3;
      margin-top: 4px;
    }
    .header-text .edition {
      font-size: 0.9em;
      color: #555;
      margin-top: 6px;
    }
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px 20px;
      text-align: center;
    }
    .hero-logo {
      margin-bottom: 30px;
    }
    .hero-logo img {
      height: 140px;
      width: auto;
    }
    .hero-title {
      font-size: 2em;
      font-weight: 800;
      color: #c0392b;
      margin-bottom: 10px;
      line-height: 1.2;
    }
    .hero-subtitle {
      font-size: 1.1em;
      color: #555;
      margin-bottom: 8px;
    }
    .hero-edition {
      display: inline-block;
      background: #c0392b;
      color: #fff;
      padding: 4px 18px;
      border-radius: 20px;
      font-size: 0.9em;
      font-weight: 700;
      margin-bottom: 30px;
    }
    .hero-desc {
      font-size: 1em;
      max-width: 620px;
      margin: 0 auto 40px;
      color: #555;
      line-height: 1.7;
    }
    .btn-inscrire {
      background-color: #c0392b;
      color: #fff;
      border: none;
      padding: 16px 40px;
      font-size: 1.1em;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s, transform 0.1s;
      display: inline-block;
    }
    .btn-inscrire:hover {
      background-color: #922b21;
      transform: translateY(-1px);
      color: #fff;
    }
    .closed {
      color: #c0392b;
      font-weight: bold;
      font-size: 1em;
    }
    footer {
      background: #fff;
      border-top: 3px solid #e8ecf1;
      padding: 20px;
      text-align: center;
      font-size: 0.85em;
      color: #888;
    }
    footer strong {
      color: #c0392b;
    }
  </style>
</head>
<body>
  <header>
    <img src="{{ asset('images/logo_cenou.jpg') }}" alt="Logo CENOU">
    <div class="header-text">
      <h2>Centre National des Œuvres Universitaires</h2>
      <h1>Semaine Nationale des Arts et de la Culture<br>des Universités du Burkina</h1>
      <div class="edition">SENAC-UB &mdash; Édition 2026</div>
    </div>
  </header>

  <main>
    <div class="hero-logo">
      <img src="{{ asset('images/logo_cenou.jpg') }}" alt="CENOU">
    </div>

    <h1 class="hero-title">SENAC-UB 2026</h1>
    <p class="hero-subtitle">Semaine Nationale des Arts et de la Culture des Universités du Burkina</p>
    <span class="hero-edition">Édition 2026</span>

    <p class="hero-desc">
      Bienvenue sur la plateforme officielle d'inscription à la SENAC-UB 2026.<br>
      Les étudiants participants peuvent ici effectuer leur inscription et obtenir leur badge de participation.
    </p>

    @if (Route::has('etudiants.create'))
      <a href="{{ route('etudiants.create') }}" class="btn-inscrire">S'inscrire maintenant</a>
    @else
      <p class="closed">Les inscriptions sont actuellement closes.</p>
    @endif
  </main>

  <footer>
    <p>&copy; 2026 <strong>CENOU</strong> &mdash; Centre National des Œuvres Universitaires du Burkina Faso &mdash; Tous droits réservés</p>
  </footer>
</body>
</html>
