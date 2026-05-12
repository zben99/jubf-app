<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Badge Étudiant</title>
    <style>
        @page {
            margin: 0;
            size: 100mm 138mm;
            /* Taille exacte du badge */
        }

        body {
            margin: 0;
            padding: 0;
        }

        .badge {
            width: 100mm;
            height: 138mm;
            position: relative;
            background-image: url('{{ public_path('images/badges/badge_template.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .photo {
            position: absolute;
            top: 65.8mm;
            left: 3.7mm;
            width: 34.3mm;
            height: 37.2mm;
            object-fit: cover;

        }

        .nom {
            position: absolute;
            top: 66mm;
            left: 55mm;
            font-size: 4mm;
            font-weight: bold;
            color: #000;
        }

        .prenom {
            position: absolute;
            top: 74mm;
            left: 63mm;
            font-size: 4mm;
            font-weight: bold;
            color: #222;
        }

        .universite,
        .statut,
        .discipline {
            position: absolute;
            left: 63mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #333;
        }

        .universite {
            top: 83mm;
        }

        .statut {
            top: 91mm;
        }

        .discipline {
            top: 99mm;
        }
    </style>
</head>

<body>
    <div class="badge">
        <img src="{{ public_path('storage/' . $etudiant->photo_path) }}" class="photo"
            alt="Photo de {{ $etudiant->nom }}">

        <div class="nom">{{ $etudiant->nom }}</div>
        <div class="prenom">{{ $etudiant->prenom }}</div>
        <div class="universite">{{ $etudiant->university->name ?? 'N/A' }}</div>
        <div class="statut">{{ $etudiant->statut }}</div>
        <div class="discipline">{{ $etudiant->discipline->name ?? 'N/A' }}</div>
    </div>
</body>

</html>
