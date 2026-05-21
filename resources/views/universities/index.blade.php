<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-university me-2 text-danger"></i>Universités</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Universités</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('universities.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i> Ajouter une université
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-admin">
        <div class="card-header ch-neutral d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fas fa-list me-1 text-danger"></i>{{ $universities->total() }} université(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.875rem;">
                    <thead style="background:#f8f9fb; border-bottom:2px solid #e3e6ea;">
                        <tr>
                            <th class="px-3 py-3" style="width:50px;">N°</th>
                            <th>Libellé</th>
                            <th style="width:130px;">Sigle</th>
                            <th class="text-center" style="width:130px;">Participants</th>
                            <th class="text-center" style="width:130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($universities as $i => $university)
                            <tr>
                                <td class="px-3 text-muted">{{ $universities->firstItem() + $i }}</td>
                                <td class="fw-semibold">{{ $university->name }}</td>
                                <td>
                                    @if($university->acronym)
                                        <span class="badge bg-secondary bg-opacity-25 text-dark fw-semibold">
                                            {{ $university->acronym }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php $nb = $university->etudiants()->count(); @endphp
                                    @if($nb > 0)
                                        <span class="badge rounded-pill" style="background:#c0392b;">{{ $nb }}</span>
                                    @else
                                        <span class="text-muted small">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('universities.edit', $university) }}"
                                           class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('universities.destroy', $university) }}" method="POST"
                                              onsubmit="return confirm('Supprimer « {{ addslashes($university->name) }} » ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-university fa-2x mb-2 d-block"></i>
                                    Aucune université enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($universities->hasPages())
            <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
                <small class="text-muted">Page {{ $universities->currentPage() }} / {{ $universities->lastPage() }}</small>
                {{ $universities->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
