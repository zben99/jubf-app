<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-users me-2 text-danger"></i>Candidats inscrits</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Candidats</li>
                    </ol>
                </nav>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('etudiants.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i> Inscrire un candidat
            </a>
            @endif
        </div>
    </x-slot>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('etudiants.index') }}" class="card card-admin mb-3">
        <div class="card-body py-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small mb-1">Recherche</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Nom, prénom, INE, matricule…"
                           value="{{ $search }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small mb-1">Université</label>
                    <select name="university_id" class="form-select form-select-sm">
                        <option value="">Toutes les universités</option>
                        @foreach ($universities as $u)
                            <option value="{{ $u->id }}" {{ $universityId == $u->id ? 'selected' : '' }}>
                                {{ $u->acronym ?: $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">Discipline</label>
                    <select name="discipline_id" class="form-select form-select-sm">
                        <option value="">Toutes</option>
                        @foreach ($disciplines as $d)
                            <option value="{{ $d->id }}" {{ $disciplineId == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small mb-1">Statut</label>
                    <select name="statut" class="form-select form-select-sm">
                        <option value="">Tous</option>
                        <option value="Artiste"   {{ $statut == 'Artiste'   ? 'selected' : '' }}>Artiste</option>
                        <option value="Sportif"   {{ $statut == 'Sportif'   ? 'selected' : '' }}>Sportif</option>
                        <option value="Encadreur" {{ $statut == 'Encadreur' ? 'selected' : '' }}>Encadreur</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- Tableau --}}
    <div class="card card-admin">
        <div class="card-header ch-neutral d-flex justify-content-between align-items-center">
            <span class="fw-bold">
                <i class="fas fa-list me-1 text-danger"></i>
                {{ $etudiants->total() }} candidat{{ $etudiants->total() > 1 ? 's' : '' }}
                @if($search || $universityId || $disciplineId || $statut)
                    <span class="badge bg-danger ms-1">filtrés</span>
                @endif
            </span>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('badges.download.batch') }}" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-download me-1"></i> Télécharger tous les badges
            </a>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
                    <thead style="background:#f8f9fb; border-bottom:2px solid #e3e6ea;">
                        <tr>
                            <th class="px-3 py-3">N°</th>
                            <th>Photo</th>
                            <th>Nom &amp; Prénom</th>
                            <th>Université</th>
                            <th>Discipline</th>
                            <th>Statut</th>
                            <th>Téléphone</th>
                            <th>Code</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($etudiants as $i => $etudiant)
                            <tr>
                                <td class="px-3 text-muted">{{ $etudiants->firstItem() + $i }}</td>
                                <td>
                                    @if ($etudiant->photo_path)
                                        <img src="{{ asset('storage/' . $etudiant->photo_path) }}"
                                             alt="Photo"
                                             style="width:44px;height:44px;object-fit:cover;border-radius:6px;border:2px solid #e3e6ea;">
                                    @else
                                        <div style="width:44px;height:44px;border-radius:6px;background:#f0f2f5;display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $etudiant->nom }}</div>
                                    <div class="text-muted small">{{ $etudiant->prenom }}</div>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width:160px;"
                                          title="{{ $etudiant->university->name ?? '' }}">
                                        {{ $etudiant->university->acronym ?? ($etudiant->university->name ?? '—') }}
                                    </span>
                                </td>
                                <td>{{ $etudiant->discipline->name ?? '—' }}</td>
                                <td>
                                    @php $s = $etudiant->statut; @endphp
                                    <span class="badge rounded-pill
                                        {{ $s === 'Artiste'   ? 'badge-artiste'   : '' }}
                                        {{ $s === 'Sportif'   ? 'badge-sportif'   : '' }}
                                        {{ $s === 'Encadreur' ? 'badge-encadreur' : '' }}">
                                        {{ $s }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $etudiant->telephone ?? '—' }}</td>
                                <td><code>{{ $etudiant->code }}</code></td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('etudiants.show', $etudiant) }}"
                                           class="btn btn-sm btn-outline-secondary" title="Voir la fiche">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(Auth::user()->isAdmin())
                                        <a href="{{ route('badges.show', $etudiant->id) }}"
                                           class="btn btn-sm btn-outline-danger" title="Badge PDF">
                                            <i class="fas fa-id-badge"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                    Aucun candidat trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($etudiants->hasPages())
            <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
                <small class="text-muted">
                    Page {{ $etudiants->currentPage() }} / {{ $etudiants->lastPage() }}
                    &mdash; {{ $etudiants->total() }} résultats
                </small>
                {{ $etudiants->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
