<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3 shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title">Étudiants inscrits</h5>
                            <p class="card-text fs-2">{{ $nombreInscriptions }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
