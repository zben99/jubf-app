<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-dark">
                {{ __('Détails de l\'Étudiant') }}
            </h2>
            <div>
                <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">{{ $etudiant->nom }} {{ $etudiant->prenom }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-4">
                                    @if ($etudiant->photo_path)
                                        <img src="{{ asset('storage/' . $etudiant->photo_path) }}"
                                            alt="Photo de {{ $etudiant->nom }}" class="img-fluid rounded shadow"
                                            style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width: 200px; height: 200px; margin: 0 auto;">
                                            <i class="fas fa-user fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <span class="badge bg-primary fs-6">Code: {{ $etudiant->code }}</span>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <h6 class="text-muted mb-3">Informations personnelles</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Nom :</td>
                                                    <td>{{ $etudiant->nom }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Prénom :</td>
                                                    <td>{{ $etudiant->prenom }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">INE :</td>
                                                    <td>{{ $etudiant->ine ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Matricule :</td>
                                                    <td>{{ $etudiant->matricule ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Date de naissance :</td>
                                                    <td>{{ $etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Téléphone :</td>
                                                    <td>{{ $etudiant->telephone ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Statut :</td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $etudiant->statut }}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <hr>

                                    <h6 class="text-muted mb-3">Informations académiques</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Université :</td>
                                                    <td>{{ $etudiant->university->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Sigle :</td>
                                                    <td>{{ $etudiant->university->acronym ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Discipline :</td>
                                                    <td>{{ $etudiant->discipline->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Catégorie :</td>
                                                    <td>{{ $etudiant->discipline->category ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
