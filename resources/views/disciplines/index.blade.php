<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-music me-2 text-danger"></i>Disciplines</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item active">Disciplines</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('disciplines.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i> Ajouter une discipline
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
            <span class="fw-bold"><i class="fas fa-list me-1 text-danger"></i>{{ $disciplines->total() }} discipline(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.875rem;">
                    <thead style="background:#f8f9fb; border-bottom:2px solid #e3e6ea;">
                        <tr>
                            <th class="px-3 py-3" style="width:50px;">N°</th>
                            <th>Discipline</th>
                            <th class="text-center" style="width:150px;">Participants</th>
                            <th class="text-center" style="width:130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($disciplines as $i => $discipline)
                            <tr>
                                <td class="px-3 text-muted">{{ $disciplines->firstItem() + $i }}</td>
                                <td class="fw-semibold">
                                    <i class="fas fa-star-half-alt text-warning me-2" style="font-size:.75rem;"></i>
                                    {{ $discipline->name }}
                                </td>
                                <td class="text-center">
                                    @php $nb = $discipline->etudiants()->count(); @endphp
                                    @if($nb > 0)
                                        <span class="badge rounded-pill" style="background:#c0392b;">{{ $nb }}</span>
                                    @else
                                        <span class="text-muted small">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('disciplines.edit', $discipline) }}"
                                           class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('disciplines.destroy', $discipline) }}" method="POST"
                                              onsubmit="return confirm('Supprimer « {{ addslashes($discipline->name) }} » ?')">
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
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-music fa-2x mb-2 d-block"></i>
                                    Aucune discipline enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($disciplines->hasPages())
            <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
                <small class="text-muted">Page {{ $disciplines->currentPage() }} / {{ $disciplines->lastPage() }}</small>
                {{ $disciplines->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
