<x-app-layout>
    <x-slot name="header">
        <div>
            <h2><i class="fas fa-pen me-2 text-danger"></i>Modifier une discipline</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('disciplines.index') }}">Disciplines</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card card-admin">
                <div class="card-header">
                    <i class="fas fa-music me-2"></i> {{ $discipline->name }}
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('disciplines.update', $discipline) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Libellé de la discipline <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $discipline->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        @php $nb = $discipline->etudiants()->count(); @endphp
                        @if($nb > 0)
                            <div class="alert alert-light border mb-3" style="font-size:.85rem;">
                                <i class="fas fa-info-circle text-danger me-1"></i>
                                <strong>{{ $nb }} candidat(s)</strong> sont inscrits dans cette discipline.
                            </div>
                        @endif

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-save me-1"></i> Mettre à jour
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
