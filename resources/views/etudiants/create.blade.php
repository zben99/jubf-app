<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription – CENOU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --cenou-orange: #E67E22;
            --cenou-blue: #2980B9;
            --cenou-green: #27AE60;
            --cenou-yellow: #F1C40F;
        }

        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .top-logo {
            background-color: #fff;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-logo img {
            max-width: 180px;
            height: auto;
        }

        .card-custom {
            border: none;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .form-header {
            background-color: var(--cenou-orange);
            color: #fff;
            padding: 1rem 1.5rem;
        }

        .form-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 500;
        }

        .card-body {
            background-color: #fff;
            padding: 1.5rem;
        }

        .form-label {
            color: var(--cenou-blue);
            font-weight: 500;
        }

        .btn-submit {
            background-color: var(--cenou-orange);
            border-color: var(--cenou-orange);
            font-weight: 500;
            padding: 0.75rem;
        }

        .btn-submit:hover {
            background-color: #cd6b1d;
            border-color: #cd6b1d;
        }

        .underline-accent {
            height: 5px;
            background: linear-gradient(to right,
                    var(--cenou-green) 0%,
                    var(--cenou-green) 50%,
                    var(--cenou-yellow) 50%,
                    var(--cenou-yellow) 100%);
        }

        .text-uppercase-input {
            text-transform: uppercase;
        }

        /* Affichage amélioré de l'upload image */
        .photo-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-preview {
            max-width: 120px;
            max-height: 120px;
            margin-bottom: 10px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <header class="top-logo text-center mb-4">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo_cenou-removebg.png') }}" alt="Logo CENOU">
        </a>
    </header>

    <div class="container">
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
                        <h2>Formulaire d'inscription JUBF 2025</h2>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('etudiants.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nom" id="nom"
                                        class="form-control text-uppercase-input @error('nom') is-invalid @enderror"
                                        value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prenom" class="form-label">Prénom <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="prenom" id="prenom"
                                        class="form-control text-uppercase-input @error('prenom') is-invalid @enderror"
                                        value="{{ old('prenom') }}" required>
                                    @error('prenom')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="ine" class="form-label">INE <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="ine" id="ine"
                                        class="form-control @error('ine') is-invalid @enderror"
                                        value="{{ old('ine') }}">
                                    <div class="form-text">Requis si le matricule est vide.</div>
                                    @error('ine')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="matricule" class="form-label">Matricule <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="matricule" id="matricule"
                                        class="form-control @error('matricule') is-invalid @enderror"
                                        value="{{ old('matricule') }}">
                                    <div class="form-text">Requis si l'INE est vide.</div>
                                    @error('matricule')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="date_naissance" class="form-label">Date de naissance <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="date_naissance" id="date_naissance"
                                        class="form-control @error('date_naissance') is-invalid @enderror"
                                        value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" name="telephone" id="telephone"
                                        class="form-control @error('telephone') is-invalid @enderror"
                                        value="{{ old('telephone') }}">
                                    @error('telephone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="university_id" class="form-label">Université <span
                                            class="text-danger">*</span></label>
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
                                    @error('university_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="statut" class="form-label">Statut <span
                                            class="text-danger">*</span></label>
                                    <select name="statut" id="statut"
                                        class="form-select @error('statut') is-invalid @enderror" required>
                                        <option value="">-- Sélectionnez --</option>
                                        <option value="Sportif" {{ old('statut') == 'Sportif' ? 'selected' : '' }}>
                                            Sportif</option>
                                        <option value="Artiste" {{ old('statut') == 'Artiste' ? 'selected' : '' }}>
                                            Artiste</option>
                                        <option value="Encadreur"
                                            {{ old('statut') == 'Encadreur' ? 'selected' : '' }}>
                                            Encadreur</option>
                                    </select>
                                    @error('statut')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="discipline_id" class="form-label">Discipline sportive / loisir <span
                                            class="text-danger">*</span></label>
                                    <select name="discipline_id" id="discipline_id"
                                        class="form-select @error('discipline_id') is-invalid @enderror" required>
                                        <option value="">-- Sélectionnez une discipline --</option>
                                        @foreach ($disciplines as $discipline)
                                            <option value="{{ $discipline->id }}"
                                                {{ old('discipline_id') == $discipline->id ? 'selected' : '' }}>
                                                {{ $discipline->name }}
                                                {{ $discipline->category ? '(' . $discipline->category . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('discipline_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Upload propre de la photo --}}
                                <div class="col-md-6 mb-3">
                                    <label for="photo_path" class="form-label">Photo de l’étudiant <span
                                            class="text-danger">*</span></label>
                                    <div class="photo-upload">
                                        <img src="#" alt="Prévisualisation" class="photo-preview d-none"
                                            id="previewImage">
                                        <input type="file" name="photo_path" id="photo_path"
                                            class="form-control @error('photo_path') is-invalid @enderror"
                                            accept="image/*" required>
                                        <div class="form-text">JPG, PNG. Max 2 Mo.</div>
                                        @error('photo_path')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-submit text-white">
                                    Soumettre
                                </button>
                                <br>
                                <a href="/" class="btn btn-danger text-white">
                                    Retour
                                </a>

                            </div>
                        </form>
                    </div>

                    <div class="underline-accent"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ['nom', 'prenom'].forEach(function(id) {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                }
            });

            const photoInput = document.getElementById('photo_path');
            const previewImage = document.getElementById('previewImage');

            if (photoInput) {
                photoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove('d-none');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>

</html>
