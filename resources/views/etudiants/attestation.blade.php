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
            width: 297mm;
            height: 210mm;
            page-break-after: always;
            background: url('file://{{ public_path('images/attestation.png') }}') no-repeat center center;
            background-size: 297mm 210mm;
        }

        /* Nom complet + université dans la zone vide sous "ATTESTE QUE :" */
        .nom-complet {
            position: absolute;
            top: 59mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 6mm;
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
            color: #000;
            text-align: center;
            white-space: nowrap;
        }

        .universite {
            position: absolute;
            top: 67mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 4.5mm;
            font-family: "Times New Roman", Times, serif;
            color: #000;
            text-align: center;
            white-space: nowrap;
        }

        /* Statut dans la zone vide après "en tant que" */
        .statut {
            position: absolute;
            top: 111mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 5.5mm;
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
            color: #000;
            text-align: center;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    @foreach ($etudiants as $attestation)
        <div class="page">
            @php
                $universite = trim($attestation->university->name ?? '');
                $debut = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($universite));

                if (\Illuminate\Support\Str::startsWith($debut, 'universite')) {
                    $prefixeUniv = "de l'";
                } elseif (\Illuminate\Support\Str::startsWith($debut, 'centre universitaire')) {
                    $prefixeUniv = 'du ';
                } else {
                    $prefixeUniv = 'de ';
                }
            @endphp

            <div class="nom-complet">
                {{ strtoupper($attestation->nom) }} {{ ucwords(strtolower($attestation->prenom)) }}
            </div>

            <div class="universite">
                {{ $prefixeUniv }}{{ $universite ?: 'N/A' }}
            </div>

            <div class="statut">
                {{ ucwords(strtolower($attestation->statut)) }}
            </div>
        </div>
    @endforeach
</body>

</html>
