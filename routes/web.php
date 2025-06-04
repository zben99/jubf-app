<?php

use App\Models\Etudiant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EtudiantController;

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


Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');

Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');


require __DIR__.'/auth.php';
