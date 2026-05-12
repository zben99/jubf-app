<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-dark">
                {{ __('Gestion des Universités') }}
            </h2>
            <a href="{{ route('universities.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter une université
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Tableau des universités -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered text-center">
                            <thead class="table-light">
                               <tr>
                                    <th>N°</th>
                                    <th>Libellé</th>
                                    <th>Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($universities as $index => $university)
                                    <tr>
                                         <td>{{ $index + 1 }}</td>
                                        <td>{{ $university->name }}</td>
                                        <td>{{ $university->acronym ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('universities.show', $university) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('universities.edit', $university) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('universities.destroy', $university) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette université ?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-muted text-center">Aucune université trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $universities->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>