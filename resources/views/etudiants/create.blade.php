<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription – SENAC-UB 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          onerror="this.onerror=null;this.href='{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}'">

    <style>
        :root {
            --cenou-red:    #c0392b;
            --cenou-orange: #E67E22;
            --cenou-blue:   #2980B9;
            --cenou-green:  #27AE60;
            --cenou-yellow: #F1C40F;
        }

        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ---- En-tête ---- */
        .top-header {
            background: #fff;
            border-bottom: 4px solid var(--cenou-red);
            padding: 16px 0 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            text-align: center;
        }
        .top-header img {
            height: 90px;
            width: auto;
        }
        .top-header .competition-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--cenou-red);
            margin-top: 8px;
            line-height: 1.3;
        }
        .top-header .competition-sub {
            font-size: 0.8rem;
            color: #666;
        }
        .top-header .edition-badge {
            display: inline-block;
            background: var(--cenou-red);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 14px;
            border-radius: 20px;
            margin-top: 4px;
        }

        /* ---- Carte formulaire ---- */
        .card-custom {
            border: none;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .form-header {
            background-color: var(--cenou-red);
            color: #fff;
            padding: 1rem 1.5rem;
        }
        .form-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .form-header small {
            font-size: 0.8rem;
            opacity: 0.85;
        }
        .card-body {
            background-color: #fff;
            padding: 1.5rem;
        }
        .form-label {
            color: var(--cenou-blue);
            font-weight: 600;
        }
        .btn-submit {
            background-color: var(--cenou-red);
            border-color: var(--cenou-red);
            font-weight: 600;
            padding: 0.75rem;
        }
        .btn-submit:hover {
            background-color: #922b21;
            border-color: #922b21;
        }
        .underline-accent {
            height: 5px;
            background: linear-gradient(to right,
                var(--cenou-orange) 0%, var(--cenou-orange) 33%,
                var(--cenou-red)    33%, var(--cenou-red)    66%,
                var(--cenou-green)  66%, var(--cenou-green)  100%);
        }
        .text-uppercase-input { text-transform: uppercase; }
        .photo-upload { display: flex; flex-direction: column; align-items: center; }
        .photo-preview {
            max-width: 120px;
            max-height: 120px;
            margin-bottom: 10px;
            border-radius: 6px;
            object-fit: cover;
            border: 2px solid #ddd;
        }
    </style>
</head>

<body>

    <header class="top-header">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo_cenou.jpg') }}" alt="Logo CENOU">
        </a>
        <div class="competition-name">
            Semaine Nationale des Arts et de la Culture des Universités du Burkina
        </div>
        <div class="competition-sub">Centre National des Œuvres Universitaires &mdash; CENOU</div>
        <div><span class="edition-badge">SENAC-UB &mdash; Édition 2026</span></div>
    </header>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {!! session('success') !!}
                    </div>
                @endif

                @if ($errors->has('doublon'))
                    <div class="alert alert-danger text-center">
                        {{ $errors->first('doublon') }}
                    </div>
                @endif

                <div class="card card-custom shadow-sm mb-5">
                    <div class="form-header">
                        <h2>Formulaire d'inscription – SENAC-UB 2026</h2>
                        <small>Remplissez tous les champs obligatoires (*)</small>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('etudiants.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nom / Prénom --}}
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" id="nom"
                                        class="form-control text-uppercase-input @error('nom') is-invalid @enderror"
                                        value="{{ old('nom') }}" required>
                                    @error('nom')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prenom" class="form-label">Prénom(s) <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" id="prenom"
                                        class="form-control text-uppercase-input @error('prenom') is-invalid @enderror"
                                        value="{{ old('prenom') }}" required>
                                    @error('prenom')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            {{-- Sexe --}}
                            <div class="mb-3">
                                <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('sexe') is-invalid @enderror"
                                            type="radio" name="sexe" id="sexe_m" value="Masculin"
                                            {{ old('sexe') === 'Masculin' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="sexe_m">Masculin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('sexe') is-invalid @enderror"
                                            type="radio" name="sexe" id="sexe_f" value="Féminin"
                                            {{ old('sexe') === 'Féminin' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sexe_f">Féminin</label>
                                    </div>
                                </div>
                                @error('sexe')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            {{-- INE / Matricule --}}
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="ine" class="form-label">
                                        INE <span id="ine-required-star" class="text-danger"></span>
                                    </label>
                                    <input type="text" name="ine" id="ine"
                                        class="form-control @error('ine') is-invalid @enderror"
                                        value="{{ old('ine') }}">
                                    <div class="form-text" id="ine-hint">Requis si le matricule est vide.</div>
                                    @error('ine')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="matricule" class="form-label">
                                        Matricule <span id="matricule-required-star" class="text-danger"></span>
                                    </label>
                                    <input type="text" name="matricule" id="matricule"
                                        class="form-control @error('matricule') is-invalid @enderror"
                                        value="{{ old('matricule') }}">
                                    <div class="form-text" id="matricule-hint">Requis si l'INE est vide.</div>
                                    @error('matricule')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            {{-- Date de naissance / Téléphone --}}
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="date_naissance" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                                    <input type="date" name="date_naissance" id="date_naissance"
                                        class="form-control @error('date_naissance') is-invalid @enderror"
                                        value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" name="telephone" id="telephone"
                                        class="form-control @error('telephone') is-invalid @enderror"
                                        value="{{ old('telephone') }}">
                                    @error('telephone')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            {{-- Université / Statut --}}
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="university_id" class="form-label">Université <span class="text-danger">*</span></label>
                                    <select name="university_id" id="university_id"
                                        class="form-select @error('university_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionnez une université --</option>
                                        @foreach ($universities as $university)
                                            <option value="{{ $university->id }}"
                                                {{ old('university_id') == $university->id ? 'selected' : '' }}>
                                                {{ $university->name }}
                                                {{ $university->acronym ? '(' . $university->acronym . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('university_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="statut" class="form-label">Statut <span class="text-danger">*</span></label>
                                    <select name="statut" id="statut"
                                        class="form-select @error('statut') is-invalid @enderror" required>
                                        <option value="">-- Sélectionnez --</option>
                                        <option value="Artiste"      {{ old('statut') == 'Artiste'      ? 'selected' : '' }}>Artiste</option>
                                        <option value="Sportif"      {{ old('statut') == 'Sportif'      ? 'selected' : '' }}>Sportif</option>
                                        <option value="Encadreur"    {{ old('statut') == 'Encadreur'    ? 'selected' : '' }}>Encadreur</option>
                                        <option value="Organisateur" {{ old('statut') == 'Organisateur' ? 'selected' : '' }}>Organisateur</option>
                                    </select>
                                    @error('statut')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            {{-- Discipline / Photo --}}
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="discipline_id" class="form-label">Discipline <span class="text-danger">*</span></label>
                                    <select name="discipline_id" id="discipline_id"
                                        class="form-select @error('discipline_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionnez une discipline --</option>
                                        @foreach ($disciplines as $discipline)
                                            <option value="{{ $discipline->id }}"
                                                {{ old('discipline_id') == $discipline->id ? 'selected' : '' }}>
                                                {{ $discipline->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('discipline_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="photo_path" class="form-label">Photo du candidat <span class="text-danger">*</span></label>
                                    <div class="photo-upload">
                                        <img src="#" alt="Prévisualisation" class="photo-preview d-none" id="previewImage">
                                        <input type="file" name="photo_path" id="photo_path"
                                            class="form-control @error('photo_path') is-invalid @enderror"
                                            accept="image/*" required>
                                        <div class="form-text">JPG, PNG. Max 2 Mo.</div>
                                        @error('photo_path')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-submit text-white">
                                    Valider l'inscription
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="underline-accent"></div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            onerror="this.onerror=null;this.src='{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}'"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ['nom', 'prenom'].forEach(function (id) {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function () {
                        this.value = this.value.toUpperCase();
                    });
                }
            });

            const photoInput   = document.getElementById('photo_path');
            const previewImage = document.getElementById('previewImage');
            if (photoInput) {
                photoInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove('d-none');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Ajustement INE/Matricule selon le statut
            const statutSelect      = document.getElementById('statut');
            const ineRequiredStar   = document.getElementById('ine-required-star');
            const matriculeRequiredStar = document.getElementById('matricule-required-star');
            const ineHint           = document.getElementById('ine-hint');
            const matriculeHint     = document.getElementById('matricule-hint');

            function updateIneMatriculeStatus() {
                const statut = statutSelect ? statutSelect.value : '';
                const isOptional = statut === 'Encadreur' || statut === 'Organisateur';

                if (isOptional) {
                    ineRequiredStar.textContent       = '';
                    matriculeRequiredStar.textContent  = '';
                    ineHint.textContent               = 'Optionnel pour ce statut.';
                    matriculeHint.textContent         = 'Optionnel pour ce statut.';
                } else {
                    ineRequiredStar.textContent       = '*';
                    matriculeRequiredStar.textContent  = '*';
                    ineHint.textContent               = 'Requis si le matricule est vide.';
                    matriculeHint.textContent         = 'Requis si l\'INE est vide.';
                }
            }

            if (statutSelect) {
                statutSelect.addEventListener('change', updateIneMatriculeStatus);
                updateIneMatriculeStatus();
            }
        });
    </script>
</body>

</html>
