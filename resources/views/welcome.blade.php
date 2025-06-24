<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Inscriptions JUBF</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      color: #333;
      text-align: center;
      padding: 40px 20px;
    }
    header {
      background-color: #fff;
      padding: 20px;
      border-bottom: 5px solid #2e86de;
    }
    header img {
      height: 100px;
    }
    h1 {
      color: #e67e22;
      font-size: 2.5em;
      margin-top: 20px;
    }
    p {
      font-size: 1.2em;
      max-width: 700px;
      margin: 20px auto 40px;
      color: #444;
    }
    .btn-inscrire {
      background-color: #2e86de;
      color: #fff;
      border: none;
      padding: 15px 30px;
      font-size: 1.2em;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }
    .btn-inscrire:hover {
      background-color: #1b4f72;
    }
    footer {
      margin-top: 60px;
      font-size: 0.9em;
      color: #777;
    }
  </style>
</head>
<body>
  <header>
    <img src="{{asset('images/logo_cenou-removebg.png')}}" alt="Logo CENOU">
  </header>

<main>
  <h1>Jeux Universitaires du Burkina Faso (JUBF)</h1>
  <p>
    Bienvenue sur la plateforme officielle d’inscription aux JUBF 2025 ! <br>
    Tous les étudiants participants peuvent ici faire leur demande de badge et attestation de participation.
  </p>

  @if (Route::has('etudiants.create'))
    <a href="{{ route('etudiants.create') }}" class="btn-inscrire">S’inscrire maintenant</a>
  @else
    <p style="color: red; font-weight: bold;">Les inscriptions sont actuellement closes.</p>
  @endif
</main>

  <footer>
    <p>© 2025 CENOU - Tous droits réservés</p>
  </footer>
</body>
</html>
