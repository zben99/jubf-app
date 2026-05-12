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
            font-family: sans-serif;
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
            background-size: cover;
            background-repeat: no-repeat;
        }
        .pos-1 { position: absolute; top: 0mm; left: 0mm; }
        .pos-2 { position: absolute; top: 0mm; left: 105mm; }
        .pos-3 { position: absolute; top: 138mm; left: 0mm; }
        .pos-4 { position: absolute; top: 138mm; left: 105mm; }

        .photo {
            position: absolute;
            top: 65.8mm;
            left: 3.7mm;
            width: 34.3mm;
            height: 37.2mm;
            object-fit: cover;
        }

        .nom        { position: absolute; top: 66mm;  left: 55mm; font-size: 4mm; font-weight: bold; }
        .prenom     { position: absolute; top: 74mm;  left: 63mm; font-size: 4mm; font-weight: bold; }
        .universite { position: absolute; top: 83mm;  left: 63mm; font-size: 3.5mm; font-weight: bold; }
        .statut     { position: absolute; top: 91mm;  left: 63mm; font-size: 3.5mm; font-weight: bold; }
        .discipline { position: absolute; top: 99mm;  left: 63mm; font-size: 3.5mm; font-weight: bold; }
    </style>
</head>
<body>

@php $chunks = $etudiants->chunk(4); @endphp

@foreach ($chunks as $chunk)
    {{-- PAGE RECTO --}}
    <div class="page">
        @foreach ($chunk as $etudiant)
            <div class="badge pos-{{ $loop->iteration }}"
                 style="background-image: url('file://{{ public_path("images/badges/badge_template.png") }}');">
                @if (!empty($etudiant->photo_path))
                    <img src="file://{{ storage_path('app/public/' . $etudiant->photo_path) }}" class="photo" alt="Photo">
                @endif
                <div class="nom">{{ ucfirst(strtolower($etudiant->nom)) }}</div>
                <div class="prenom">{{ ucfirst(strtolower($etudiant->prenom)) }}</div>
                <div class="universite">{{ ucfirst(strtolower($etudiant->university->name ?? 'N/A')) }}</div>
                <div class="statut">{{ ucfirst(strtolower($etudiant->statut)) }}</div>
                <div class="discipline">{{ ucfirst(strtolower($etudiant->discipline->name ?? 'N/A')) }}</div>
            </div>
        @endforeach
    </div>

    {{-- PAGE VERSO --}}
    <div class="page">
        @foreach ($chunk as $etudiant)
            <div class="verso pos-{{ $loop->iteration }}"
                 style="background-image: url('file://{{ public_path("images/badges/verso_template.png") }}');">
            </div>
        @endforeach
    </div>
@endforeach

</body>
</html>
