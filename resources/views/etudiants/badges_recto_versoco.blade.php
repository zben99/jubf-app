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

        /* 4 emplacements : 2 colonnes × 2 lignes (105mm × 148mm) */
        .badge,
        .verso {
            width: 105mm;
            height: 148mm;
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

        /* Photo comité (grand emplacement centré) */
        .photo-co {
            position: absolute;
            top: 55mm;
            left: 36mm;
            width: 45mm;
            height: 44mm;
            object-fit: cover;
            border-radius: 2mm;
        }

        /* Valeurs texte – labels rouge déjà gravés dans la maquette */
        .val-nom-co {
            position: absolute;
            top: 96mm;
            left: 40mm;
            font-size: 5mm;
            font-weight: bold;
            color: #222;
            max-width: 55mm;
        }

        .val-prenom-co {
            position: absolute;
            top: 104mm;
            left: 54mm;
            font-size: 5mm;
            font-weight: bold;
            color: #222;
            max-width: 42mm;
        }

        .val-fonction-co {
            position: absolute;
            top: 112mm;
            left: 45mm;
            font-size: 5mm;
            font-weight: bold;
            color: #222;
            max-width: 50mm;
        }
    </style>
</head>

<body>

    {{-- PAGE RECTO – badges comité d'organisation --}}
    <div class="page">
        @for ($i = 1; $i <= 4; $i++)
            <div class="badge pos-{{ $i }}"
                style="background-image: url('file://{{ public_path('images/badges/badge_comite.png') }}');">
                @if (isset($membres) && isset($membres[$i - 1]))
                    @php $m = $membres[$i - 1]; @endphp
                    @if (!empty($m->photo_path))
                        <img src="file://{{ public_path('storage/' . $m->photo_path) }}" class="photo-co"
                            alt="Photo">
                    @endif
                    <div class="val-nom-co">{{ strtoupper($m->nom) }}</div>
                    <div class="val-prenom-co">{{ ucfirst(strtolower($m->prenom)) }}</div>
                    <div class="val-fonction-co">{{ $m->fonction ?? '' }}</div>
                @endif
            </div>
        @endfor
    </div>

    {{-- PAGE VERSO --}}
    <div class="page">
        @for ($i = 1; $i <= 4; $i++)
            <div class="verso pos-{{ $i }}"
                style="background-image: url('file://{{ public_path('images/badges/verso_templateco.png') }}');">
            </div>
        @endfor
    </div>

</body>

</html>
