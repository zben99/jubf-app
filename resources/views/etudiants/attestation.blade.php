<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestations</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .page {
            position: relative;
            width: 100%;
            height: 100%;
            page-break-after: always;
            background: url('file://{{ public_path("images/attestation.png") }}') no-repeat center center;
            background-size: cover;
        }

        .nom-complet {
            position: absolute;
            top: 345px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 22px;
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
            color: #000;
            text-align: center;
        }

            .statut {
            position: absolute;
            top: 430px;
            left: 46.5%;
            transform: translateX(-50%);
            font-size: 22px;
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>
            @foreach($etudiants as $attestation)
                    <div class="page">
           @php



                $universite = trim($attestation->university->name ?? '');
                $universiteFormatee = $universite ?: 'N/A';

                // Normaliser pour comparaison
                $debut = Str::lower(Str::ascii($universite)); // ignore accents

                if (Str::startsWith($debut, 'universite')) {
                    $prefixe = 'de l’';
                } elseif (Str::startsWith($debut, 'centre universitaire')) {
                    $prefixe = 'du ';
                } else {
                    $prefixe = 'de l’établissement';
                }
            @endphp

            <div class="nom-complet">
                {{ strtoupper($attestation->nom) }} {{ ucwords(strtolower($attestation->prenom)) }} – {{ $prefixe }} {{ $universiteFormatee }}
            </div>

            @php
                $statut = ucwords(strtolower($attestation->statut));
                $voyelles = ['a', 'e', 'i', 'o', 'u', 'y'];
                $lettreInitiale = strtolower(substr($statut, 0, 1));
                $prefixe = in_array($lettreInitiale, $voyelles) ? "qu’" : "que ";
            @endphp

            <div class="statut">
                {{ $prefixe }}{{ $statut }}.
            </div>

        </div>
    @endforeach
</body>
</html>
