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
            box-sizing: border-box;
            page-break-after: always;
            overflow: hidden;
        }

        .verso-wrapper {
            width: 100%;
            height: auto;
            clear: both;
        }

    .verso {
        float: left;
        width: 100mm;
        height: 138mm;
        margin: 1mm;
        background-image: url('{{ public_path("images/badges/verso_template.png") }}');
        background-size: cover;
    }


    </style>
</head>
<body>
    @foreach ($etudiants as $chunk)
    <div class="page">
        @foreach ($chunk as $index => $etudiant)
            @if ($index % 2 === 0)
                <div class="badge-wrapper">
            @endif

            <div class="verso"></div>

            @if ($index % 2 === 1 || $loop->last)
                </div>
            @endif
        @endforeach
    </div>
@endforeach

</body>
</html>
