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
        width: 210mm;
        height: 297mm;
        page-break-after: always;
    }

    .badge-wrapper {
        clear: both;
    }

    .badge {
        float: left;
        width: 100mm;
        height: 138mm;
        margin: 1mm;
        background-image: url('{{ public_path("images/badges/badge_template.png") }}');
        background-size: cover;
        position: relative;
    }

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
    @foreach ($etudiants as $chunk)
    <div class="page">
        @foreach ($chunk as $index => $etudiant)
            @if ($index % 2 === 0)
                <div class="badge-wrapper">
            @endif

            <div class="badge">
                <img src="{{ public_path('storage/' . $etudiant->photo_path) }}" class="photo">
                <div class="nom">{{ $etudiant->nom }}</div>
                <div class="prenom">{{ $etudiant->prenom }}</div>
                <div class="universite">{{ $etudiant->universite }}</div>
                <div class="statut">{{ $etudiant->statut }}</div>
                <div class="discipline">{{ $etudiant->discipline }}</div>
            </div>

            @if ($index % 2 === 1 || $loop->last)
                </div>
            @endif
        @endforeach
    </div>
@endforeach

</body>
</html>
