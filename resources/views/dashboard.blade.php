<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('images/logo_cenou.jpg') }}" alt="CENOU" style="height:48px;">
            <div>
                <h2 class="font-semibold text-xl text-dark leading-tight mb-0">Tableau de bord</h2>
                <small class="text-muted">Semaine Nationale des Arts et de la Culture des Universités du Burkina &mdash; <strong class="text-danger">SENAC-UB 2026</strong></small>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid px-4">

            {{-- Alerte flash --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Bloc statut des inscriptions --}}
            <div class="card card-admin mb-4">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;background:{{ $registrationOpen ? '#d4edda' : '#f8d7da' }};">
                            <i class="fas fa-{{ $registrationOpen ? 'lock-open' : 'lock' }} fs-5"
                               style="color:{{ $registrationOpen ? '#198754' : '#c0392b' }};"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:.95rem;">
                                Inscriptions
                                <span class="badge rounded-pill ms-1 {{ $registrationOpen ? 'bg-success' : 'bg-danger' }}">
                                    {{ $registrationOpen ? 'OUVERTES' : 'FERMÉES' }}
                                </span>
                            </div>
                            <div class="text-muted small">
                                {{ $registrationOpen
                                    ? 'Le formulaire d\'inscription public est accessible.'
                                    : 'Le formulaire public est désactivé. Aucune nouvelle inscription.' }}
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('settings.toggle-registration') }}">
                        @csrf
                        <button type="submit"
                                class="btn {{ $registrationOpen ? 'btn-outline-danger' : 'btn-success' }} px-4"
                                onclick="return confirm('{{ $registrationOpen ? 'Fermer les inscriptions ?' : 'Ouvrir les inscriptions ?' }}')">
                            <i class="fas fa-{{ $registrationOpen ? 'lock' : 'lock-open' }} me-2"></i>
                            {{ $registrationOpen ? 'Fermer les inscriptions' : 'Ouvrir les inscriptions' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Cartes de résumé --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-white" style="background: #c0392b;">
                        <div class="card-body text-center py-4">
                            <div class="fs-1 fw-bold">{{ $nombreInscriptions }}</div>
                            <div class="fw-semibold">Participants inscrits</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-white" style="background: #2980b9;">
                        <div class="card-body text-center py-4">
                            <div class="fs-1 fw-bold">{{ $nombreUniversites }}</div>
                            <div class="fw-semibold">Universités</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-white" style="background: #27ae60;">
                        <div class="card-body text-center py-4">
                            <div class="fs-1 fw-bold">{{ $nombreDisciplines }}</div>
                            <div class="fw-semibold">Disciplines</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tableau de participation --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-danger">
                        Tableau de participation par université et discipline
                    </h5>
                    <small class="text-muted">Nombre de participants inscrits</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm mb-0" style="font-size: 0.78em;">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" style="min-width:30px;">N°</th>
                                    <th style="min-width:200px;">Université</th>
                                    @foreach ($disciplines as $discipline)
                                        <th class="text-center" style="min-width:70px; max-width:90px; white-space:normal; line-height:1.2;">
                                            {{ $discipline->name }}
                                        </th>
                                    @endforeach
                                    <th class="text-center fw-bold" style="min-width:60px; background:#c0392b; color:#fff;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($universities as $i => $university)
                                    @php
                                        $ligneTotal = $totauxUniversite[$university->id] ?? 0;
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted">{{ $i + 1 }}</td>
                                        <td class="fw-semibold">{{ $university->name }}</td>
                                        @foreach ($disciplines as $discipline)
                                            @php
                                                $count = $stats[$university->id][$discipline->id]->total ?? 0;
                                            @endphp
                                            <td class="text-center {{ $count > 0 ? 'fw-semibold text-primary' : 'text-muted' }}">
                                                {{ $count > 0 ? $count : '' }}
                                            </td>
                                        @endforeach
                                        <td class="text-center fw-bold {{ $ligneTotal > 0 ? 'text-danger' : 'text-muted' }}">
                                            {{ $ligneTotal ?: '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary fw-bold">
                                <tr>
                                    <td colspan="2" class="text-end">TOTAL</td>
                                    @foreach ($disciplines as $discipline)
                                        <td class="text-center">
                                            {{ $totauxDiscipline[$discipline->id] ?? '' }}
                                        </td>
                                    @endforeach
                                    <td class="text-center text-danger fw-bold">{{ $nombreInscriptions }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
