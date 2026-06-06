<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            page-break-after: always;
        }

        /* 4 badges par page A4 : 2 colonnes × 2 lignes (105mm × 148mm chacun) */
        .badge {
            width: 105mm;
            height: 150mm;
            position: absolute;
            background-size: 105mm 148mm;
            background-repeat: no-repeat;
            overflow: hidden;
        }

        .pos-1 {
            top: 0;
            left: 0;
        }

        .pos-2 {
            top: 0;
            left: 105mm;
        }

        .pos-3 {
            top: 148mm;
            left: 0;
        }

        .pos-4 {
            top: 148mm;
            left: 105mm;
        }

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
            top: 55mm;
            left: 36.8mm;
            width: 34.8mm;
            height: 36.5mm;
            object-fit: cover;
            border-radius: 4mm;
        }

        .val-nom-co {
            position: absolute;
            top: 94.5mm;
            left: 49mm;
            font-size: 5mm;
            font-weight: bold;
            color: #222;
            max-width: 55mm;
        }

        .val-prenom-co {
            position: absolute;
            top: 103mm;
            left: 49mm;
            font-size: 5mm;
            font-weight: bold;
            color: #222;
            max-width: 42mm;
        }

        .val-fonction-co {
            position: absolute;
            top: 110.5mm;
            left: 49mm;
            font-size: 5mm;
            font-weight: bold;
            color: #222;
            max-width: 50mm;
        }
    </style>
</head>

<body>
    @foreach ($etudiants as $chunk)
        <div class="page">
            @foreach ($chunk as $etudiant)
                @if ($etudiant->statut === 'Organisateur')
                    <div class="badge pos-{{ $loop->iteration }}"
                        style="background-image: url('file://{{ public_path('images/badges/badge_comite.png') }}');">
                        @if (!empty($etudiant->photo_path))
                            <img src="file://{{ public_path('storage/' . $etudiant->photo_path) }}" class="photo-co"
                                alt="Photo">
                        @endif
                        <div class="val-nom-co">{{ strtoupper($etudiant->nom) }}</div>
                        <div class="val-prenom-co">{{ ucfirst(strtolower($etudiant->prenom)) }}</div>
                        <div class="val-fonction-co">Organisateur</div>
                    </div>
                @else
                    <div class="badge pos-{{ $loop->iteration }}"
                        style="background-image: url('file://{{ public_path('images/badges/badge_participant.png') }}');">
                        @if (!empty($etudiant->photo_path))
                            <img src="file://{{ public_path('storage/' . $etudiant->photo_path) }}" class="photo"
                                alt="Photo">
                        @endif
                        <div class="val-nom">{{ strtoupper($etudiant->nom) }}</div>
                        <div class="val-prenom">{{ ucfirst(strtolower($etudiant->prenom)) }}</div>
                        <div class="val-universite">
                            {{ $etudiant->university->acronym ?? ($etudiant->university->name ?? 'N/A') }}</div>
                        <div class="val-statut">{{ ucfirst(strtolower($etudiant->statut)) }}</div>
                        <div class="val-discipline">{{ $etudiant->discipline->name ?? 'N/A' }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
</body>

</html>
