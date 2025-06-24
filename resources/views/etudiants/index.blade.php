<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-dark">
                {{ __('Liste des Étudiants') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- Barre de recherche -->
                    <form method="GET" action="{{ route('etudiants.index') }}" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-10">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Rechercher par nom, prénom, université, etc."
                                    value="{{ $search }}"
                                    class="form-control"
                                >
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Rechercher</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tableau des étudiants -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered text-center">
                            <thead class="table-light">
                               <tr>
                                    <th>N°</th>
                                    <th>Photo</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Téléphone</th>
                                    <th>Université</th>
                                    <th>Statut</th>
                                    <th>Discipline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($etudiants as $index => $etudiant)
                                    <tr>
                                         <td>{{ $index + 1 }}</td>
                                        <td>
                                              @if ($etudiant->photo_path)
                                                <img src="{{ asset('storage/' . $etudiant->photo_path) }}" alt="Photo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">Aucune</span>
                                            @endif
                                        </td>
                                        <td>{{ $etudiant->nom }}</td>
                                        <td>{{ $etudiant->prenom }}</td>
                                        <td>{{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</td>
                                        <td>{{ $etudiant->telephone }}</td>
                                        <td>{{ $etudiant->universite }}</td>
                                        <td>{{ $etudiant->statut }}</td>
                                        <td>{{ $etudiant->discipline }}</td>

                                        <td>
                                            <a href="{{ route('badges.show', $etudiant->id) }}" class="btn btn-sm btn-outline-primary">
                                                Générer badge
                                            </a>
                                        </td>
                                    </tr>
                                @empty

                                    <tr>
                                        <td colspan="8" class="text-muted text-center">Aucun étudiant trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $etudiants->appends(['search' => $search])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
