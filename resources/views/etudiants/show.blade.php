<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-user me-2 text-danger"></i>Fiche candidat</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('etudiants.index') }}">Candidats</a></li>
                        <li class="breadcrumb-item active">{{ $etudiant->nom }} {{ $etudiant->prenom }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('badges.show', $etudiant->id) }}"
                   class="btn btn-danger" target="_blank">
                    <i class="fas fa-id-badge me-1"></i> Badge PDF
                </a>
                <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row g-3">
        {{-- Colonne gauche : photo + code --}}
        <div class="col-md-3">
            <div class="card card-admin text-center">
                <div class="card-body p-4">
                    @if ($etudiant->photo_path)
                        <img src="{{ asset('storage/' . $etudiant->photo_path) }}"
                             alt="Photo"
                             class="rounded-circle mb-3 shadow"
                             style="width:120px;height:120px;object-fit:cover;border:3px solid #c0392b;">
                    @else
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow"
                             style="width:120px;height:120px;background:#f0f2f5;border:3px solid #dee2e6;">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    @endif

                    <h5 class="fw-bold mb-0">{{ $etudiant->nom }}</h5>
                    <div class="text-muted mb-2">{{ $etudiant->prenom }}</div>

                    @php $s = $etudiant->statut; @endphp
                    <span class="badge rounded-pill px-3 py-2 mb-3
                        {{ $s === 'Artiste'   ? 'badge-artiste'   : '' }}
                        {{ $s === 'Sportif'   ? 'badge-sportif'   : '' }}
                        {{ $s === 'Encadreur' ? 'badge-encadreur' : '' }}">
                        {{ $s }}
                    </span>

                    <div class="border rounded p-2 bg-light mt-2">
                        <div class="small text-muted">Code d'inscription</div>
                        <div class="fw-bold fs-5 text-danger font-monospace">{{ $etudiant->code }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne droite : informations --}}
        <div class="col-md-9">
            <div class="card card-admin">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i> Informations personnelles
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-4">
                            <div class="small text-muted fw-semibold mb-1">Nom</div>
                            <div class="fw-semibold">{{ $etudiant->nom }}</div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="small text-muted fw-semibold mb-1">Prénom(s)</div>
                            <div>{{ $etudiant->prenom }}</div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="small text-muted fw-semibold mb-1">Date de naissance</div>
                            <div>{{ $etudiant->date_naissance
                                ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y')
                                : '—' }}</div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="small text-muted fw-semibold mb-1">Téléphone</div>
                            <div>{{ $etudiant->telephone ?? '—' }}</div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="small text-muted fw-semibold mb-1">INE</div>
                            <div class="font-monospace">{{ $etudiant->ine ?? '—' }}</div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="small text-muted fw-semibold mb-1">Matricule</div>
                            <div class="font-monospace">{{ $etudiant->matricule ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-admin mt-3">
                <div class="card-header">
                    <i class="fas fa-graduation-cap me-2"></i> Participation SENAC-UB 2026
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="small text-muted fw-semibold mb-1">Université</div>
                            <div class="fw-semibold">{{ $etudiant->university->name ?? '—' }}</div>
                            @if($etudiant->university?->acronym)
                                <div class="small text-muted">{{ $etudiant->university->acronym }}</div>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <div class="small text-muted fw-semibold mb-1">Discipline</div>
                            <div class="fw-semibold">{{ $etudiant->discipline->name ?? '—' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="small text-muted fw-semibold mb-1">Statut</div>
                            <span class="badge rounded-pill
                                {{ $s === 'Artiste'   ? 'badge-artiste'   : '' }}
                                {{ $s === 'Sportif'   ? 'badge-sportif'   : '' }}
                                {{ $s === 'Encadreur' ? 'badge-encadreur' : '' }}">
                                {{ $s }}
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <div class="small text-muted fw-semibold mb-1">Inscrit le</div>
                            <div>{{ $etudiant->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
