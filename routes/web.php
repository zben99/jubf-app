<?php

use App\Models\Etudiant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\DisciplineController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $nombreInscriptions = Etudiant::count();

    return view('dashboard', compact('nombreInscriptions'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('universities', UniversityController::class);
    Route::resource('disciplines', DisciplineController::class);
});


Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');

Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');

Route::get('/etudiants/badge/{id}', [EtudiantController::class, 'generate'])->name('badge.generate');

Route::get('/badges/{id}', [EtudiantController::class, 'showBadge'])->name('badges.show');

Route::get('/badges/download/batch', [EtudiantController::class, 'telechargerBadges'])->name('badges.download.batch');


Route::get('/badges/download/batch1', [EtudiantController::class, 'telechargerBadges1'])->name('badges.download.batch1');

require __DIR__.'/auth.php';