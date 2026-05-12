<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark">
            {{ __('Modifier l\'Université') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Modifier les informations</h5>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('universities.update', $university) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row gx-3">
                                    <div class="col-md-8 mb-3">
                                        <label for="name" class="form-label">Libellé de l'université <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $university->name) }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="acronym" class="form-label">Code de l'université</label>
                                        <input type="text" name="acronym" id="acronym"
                                            class="form-control @error('acronym') is-invalid @enderror"
                                            value="{{ old('acronym', $university->acronym) }}">
                                        @error('acronym')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save"></i> Mettre à jour
                                    </button>
                                    <br>
                                    <a href="{{ route('universities.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Retour
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
