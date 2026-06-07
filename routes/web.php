<?php

use App\Models\Etudiant;
use App\Models\University;
use App\Models\Discipline;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('welcome');
});

// Inscription publique (sans authentification)
Route::get('/etudiants/create',  [EtudiantController::class, 'create'])->name('etudiants.create');
Route::post('/etudiants',        [EtudiantController::class, 'store'])->name('etudiants.store');


Route::get('/dashboard', function () {
    $nombreInscriptions = Etudiant::count();
    $nombreUniversites   = University::count();
    $nombreDisciplines   = Discipline::count();

    $universities = University::orderBy('name')->get();
    $disciplines  = Discipline::orderBy('name')->get();

    // Compter les participants par université et par discipline
    $stats = Etudiant::selectRaw('university_id, discipline_id, COUNT(*) as total')
        ->groupBy('university_id', 'discipline_id')
        ->get()
        ->groupBy('university_id')
        ->map(fn($rows) => $rows->keyBy('discipline_id'));

    // Total par université
    $totauxUniversite = Etudiant::selectRaw('university_id, COUNT(*) as total')
        ->groupBy('university_id')
        ->pluck('total', 'university_id');

    // Total par discipline
    $totauxDiscipline = Etudiant::selectRaw('discipline_id, COUNT(*) as total')
        ->groupBy('discipline_id')
        ->pluck('total', 'discipline_id');

    $registrationOpen = Setting::registrationOpen();

    return view('dashboard', compact(
        'nombreInscriptions', 'nombreUniversites', 'nombreDisciplines',
        'universities', 'disciplines', 'stats', 'totauxUniversite', 'totauxDiscipline',
        'registrationOpen'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Routes accessibles aux deux rôles (admin + cenou) ──────────────────────
Route::middleware(['auth'])->group(function () {

    // Universités & disciplines : CRUD complet pour les deux rôles
    Route::resource('universities', UniversityController::class);
    Route::resource('disciplines',  DisciplineController::class);

    // Candidats : lecture seule
    Route::get('/etudiants',              [EtudiantController::class, 'index'])->name('etudiants.index');
    Route::get('/etudiants/{etudiant}',   [EtudiantController::class, 'show'])->name('etudiants.show')->whereNumber('etudiant');

    // Configuration (toggle inscriptions)
    Route::post('/settings/toggle-registration', [SettingController::class, 'toggleRegistration'])
        ->name('settings.toggle-registration');
});

// ── Suppression candidats (admin + cenou) ────────────────────────────────
Route::middleware(['auth', 'role:admin,cenou'])->group(function () {
    Route::delete('/etudiants/bulk',       [EtudiantController::class, 'destroyBulk'])->name('etudiants.destroy-bulk');
    Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy')->whereNumber('etudiant');
});

// ── Routes réservées à l'admin uniquement ──────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {

    // (universités & disciplines gérées dans le groupe auth ci-dessus)

    // Téléchargements badges & attestations
    Route::get('/badges/export',           [EtudiantController::class, 'badgesExport'])->name('badges.export');
    Route::get('/etudiants/export-excel',  [EtudiantController::class, 'exportExcel'])->name('etudiants.export-excel');
    Route::get('/badges/all',              [EtudiantController::class, 'telechargerBadges'])->name('badges.all');
    Route::get('/badges/organisateurs',    [EtudiantController::class, 'telechargerBadgesOrganisateurs'])->name('badges.organisateurs');
    Route::get('/badges/university/{id}',  [EtudiantController::class, 'telechargerBadgesByUniversity'])->name('badges.by-university');
    Route::get('/badges/discipline/{id}',  [EtudiantController::class, 'telechargerBadgesByDiscipline'])->name('badges.by-discipline');
    Route::get('/badges/show/{id}',        [EtudiantController::class, 'showBadge'])->name('badges.show');
    Route::get('/badges/download/batch',   [EtudiantController::class, 'telechargerBadges'])->name('badges.download.batch');
    Route::get('/badges/download/batch1',  [EtudiantController::class, 'telechargerBadges1'])->name('badges.download.batch1');
});

// ── Inscription publique (sans auth) ──────────────────────────────────────

require __DIR__.'/auth.php';