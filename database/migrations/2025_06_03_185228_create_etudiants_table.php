<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('ine')->unique(); // Identifiant National Étudiant, doit être unique
            $table->string('matricule')->unique(); // Matricule, doit être unique
            $table->date('date_naissance');
            $table->string('telephone')->nullable();
            $table->string('universite')->nullable();
            $table->string('statut')->nullable(); // étudiant, professionnel, etc.
            $table->string('discipline'); // discipline sportive ou autre
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};