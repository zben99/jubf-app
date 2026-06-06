<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Badge Étudiant</title>
    <style>
        @page {
            margin: 0;
            size: 105mm 148mm;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .badge {
            width: 105mm;
            height: 148mm;
            position: relative;
            overflow: hidden;
            background-size: 105mm 148mm;
            background-repeat: no-repeat;
        }

        /* Layout participant */
        .photo {
            position: absolute;
            top: 52mm;
            left: 11mm;
            width: 26mm;
            height: 60mm;
            object-fit: cover;
        }

        .val-nom {
            position: absolute;
            top: 63mm;
            left: 57mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #fff;
            max-width: 40mm;
        }

        .val-prenom {
            position: absolute;
            top: 72mm;
            left: 69mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #fff;
            max-width: 28mm;
        }

        .val-universite {
            position: absolute;
            top: 81mm;
            left: 67mm;
            font-size: 2.8mm;
            font-weight: bold;
            color: #fff;
            max-width: 30mm;
            word-wrap: break-word;
        }

        .val-statut {
            position: absolute;
            top: 91mm;
            left: 60mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #fff;
            max-width: 37mm;
        }

        .val-discipline {
            position: absolute;
            top: 100mm;
            left: 69mm;
            font-size: 2.8mm;
            font-weight: bold;
            color: #fff;
            max-width: 28mm;
            word-wrap: break-word;
        }

        /* Layout organisateur (maquette comité) */
        .photo-co {
            position: absolute;
            top: 57mm;
            left: 38mm;
            width: 31mm;
            height: 30mm;
            object-fit: cover;
            border-radius: 2mm;
        }

        .val-nom-co {
            position: absolute;
            top: 95mm;
            left: 44mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #222;
            max-width: 55mm;
        }

        .val-prenom-co {
            position: absolute;
            top: 103mm;
            left: 57mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #222;
            max-width: 42mm;
        }

        .val-fonction-co {
            position: absolute;
            top: 110mm;
            left: 49mm;
            font-size: 3.5mm;
            font-weight: bold;
            color: #222;
            max-width: 50mm;
        }
    </style>
</head>

<body>
    @if ($etudiant->statut === 'Organisateur')
        <div class="badge" style="background-image: url('{{ public_path('images/badges/badge_comite.png') }}');">
            @if (!empty($etudiant->photo_path))
                <img src="file://{{ public_path('storage/' . $etudiant->photo_path) }}"
                     class="photo-co" alt="Photo">
            @endif
            <div class="val-nom-co">{{ strtoupper($etudiant->nom) }}</div>
            <div class="val-prenom-co">{{ ucfirst(strtolower($etudiant->prenom)) }}</div>
            <div class="val-fonction-co">Organisateur</div>
        </div>
    @else
        <div class="badge" style="background-image: url('{{ public_path('images/badges/badge_participant.png') }}');">
            @if (!empty($etudiant->photo_path))
                <img src="file://{{ public_path('storage/' . $etudiant->photo_path) }}"
                     class="photo" alt="Photo">
            @endif
            <div class="val-nom">{{ strtoupper($etudiant->nom) }}</div>
            <div class="val-prenom">{{ ucfirst(strtolower($etudiant->prenom)) }}</div>
            <div class="val-universite">{{ $etudiant->university->acronym ?? $etudiant->university->name ?? 'N/A' }}</div>
            <div class="val-statut">{{ ucfirst(strtolower($etudiant->statut)) }}</div>
            <div class="val-discipline">{{ $etudiant->discipline->name ?? 'N/A' }}</div>
        </div>
    @endif
</body>

</html>
