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

        .badge, .verso {
            width: 100mm;
            height: 138mm;
            position: absolute;
            background-size: cover;
            background-repeat: no-repeat;
        }

        /* Position des 4 emplacements */
        .pos-1 { top: 0mm; left: 0mm; }
        .pos-2 { top: 0mm; left: 105mm; }
        .pos-3 { top: 150mm; left: 0mm; }
        .pos-4 { top: 150mm; left: 105mm; }

        .photo {
            position: absolute;
            top: 65.8mm;
            left: 3.7mm;
            width: 34.3mm;
            height: 37.2mm;
            object-fit: cover;
        }

        .nom        { position: absolute; top: 66mm; left: 55mm; font-size: 4mm; font-weight: bold; }
        .prenom     { position: absolute; top: 74mm; left: 63mm; font-size: 4mm; font-weight: bold; }
        .universite { position: absolute; top: 83mm; left: 63mm; font-size: 4mm; font-weight: bold; }
        .statut     { position: absolute; top: 91mm; left: 63mm; font-size: 4mm; font-weight: bold; }
        .discipline { position: absolute; top: 99mm; left: 63mm; font-size: 4mm; font-weight: bold; }
    </style>
</head>
<body>

{{-- PAGE RECTO --}}
<div class="page">
    @for ($i = 1; $i <= 4; $i++)
        <div class="badge pos-{{ $i }}" style="background-image: url('{{ public_path("images/badges/badge_templateco.png") }}');">
        </div>
    @endfor
</div>

{{-- PAGE VERSO --}}
<div class="page">
    @for ($i = 1; $i <= 4; $i++)
        <div class="verso pos-{{ $i }}" style="background-image: url('{{ public_path("images/badges/verso_templateco.png") }}');">
        </div>
    @endfor
</div>


</body>
</html>
