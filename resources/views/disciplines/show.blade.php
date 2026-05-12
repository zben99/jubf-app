<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-dark">
                {{ __('Détails de la Discipline') }}
            </h2>
            <div>
                <a href="{{ route('disciplines.edit', $discipline) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('disciplines.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">{{ $discipline->name }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">Informations</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Libellé :</td>
                                            <td>{{ $discipline->name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <h6 class="text-muted mb-3">Statistiques</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h4 class="text-primary">{{ $discipline->etudiants()->count() }}</h4>
                                            <small class="text-muted">Étudiants inscrits</small>
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