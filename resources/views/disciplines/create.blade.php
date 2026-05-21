<x-app-layout>
    <x-slot name="header">
        <div>
            <h2><i class="fas fa-plus-circle me-2 text-danger"></i>Ajouter une discipline</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('disciplines.index') }}">Disciplines</a></li>
                    <li class="breadcrumb-item active">Ajouter</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card card-admin">
                <div class="card-header">
                    <i class="fas fa-music me-2"></i> Nouvelle discipline
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('disciplines.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Libellé de la discipline <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="ex: Théâtre, Slam, Athlétisme…" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-save me-1"></i> Enregistrer
                            </button>
                            <a href="{{ route('disciplines.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
