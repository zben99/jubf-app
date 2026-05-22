<x-app-layout>
    <x-slot name="header">
        <div>
            <h2><i class="fas fa-download me-2 text-danger"></i>Téléchargement des badges</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active">Téléchargement badges</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    {{-- Statistiques rapides --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-admin text-center py-3">
                <div class="fs-2 fw-bold text-danger">{{ $totalCandidats }}</div>
                <div class="text-muted small">Total candidats</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-admin text-center py-3">
                <div class="fs-2 fw-bold" style="color:#2980b9;">{{ $universities->count() }}</div>
                <div class="text-muted small">Universités avec participants</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-admin text-center py-3">
                <div class="fs-2 fw-bold" style="color:#27ae60;">{{ $disciplines->count() }}</div>
                <div class="text-muted small">Disciplines avec participants</div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── PAR UNIVERSITÉ ── --}}
        <div class="col-lg-6">
            <div class="card card-admin h-100">
                <div class="card-header">
                    <i class="fas fa-university me-2"></i> Badges par université
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
                            <thead style="background:#f8f9fb; border-bottom:2px solid #e3e6ea;">
                                <tr>
                                    <th class="px-3 py-2">Université</th>
                                    <th class="text-center py-2" style="width:90px;">Candidats</th>
                                    <th class="text-center py-2" style="width:110px;">Télécharger</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($universities as $university)
                                    <tr>
                                        <td class="px-3">
                                            <div class="fw-semibold" style="font-size:.82rem;">{{ $university->name }}</div>
                                            @if($university->acronym)
                                                <div class="text-muted" style="font-size:.72rem;">{{ $university->acronym }}</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill" style="background:#c0392b;">
                                                {{ $university->etudiants_count }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('badges.by-university', $university->id) }}"
                                               class="btn btn-sm btn-danger" title="Télécharger les badges">
                                                <i class="fas fa-file-pdf me-1"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($universities->isEmpty())
                                    <tr><td colspan="3" class="text-center py-4 text-muted">Aucun participant inscrit.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="{{ route('badges.all') }}" class="btn btn-danger w-100">
                        <i class="fas fa-download me-1"></i> Télécharger TOUS les badges
                    </a>
                </div>
            </div>
        </div>

        {{-- ── PAR DISCIPLINE ── --}}
        <div class="col-lg-6">
            <div class="card card-admin h-100">
                <div class="card-header">
                    <i class="fas fa-music me-2"></i> Badges par discipline
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
                            <thead style="background:#f8f9fb; border-bottom:2px solid #e3e6ea;">
                                <tr>
                                    <th class="px-3 py-2">Discipline</th>
                                    <th class="text-center py-2" style="width:90px;">Candidats</th>
                                    <th class="text-center py-2" style="width:110px;">Télécharger</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($disciplines as $discipline)
                                    <tr>
                                        <td class="px-3 fw-semibold">{{ $discipline->name }}</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill" style="background:#c0392b;">
                                                {{ $discipline->etudiants_count }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('badges.by-discipline', $discipline->id) }}"
                                               class="btn btn-sm btn-danger" title="Télécharger les badges">
                                                <i class="fas fa-file-pdf me-1"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($disciplines->isEmpty())
                                    <tr><td colspan="3" class="text-center py-4 text-muted">Aucun participant inscrit.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="{{ route('badges.all') }}" class="btn btn-outline-danger w-100">
                        <i class="fas fa-download me-1"></i> Télécharger TOUS les badges
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
