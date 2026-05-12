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
        Schema::table('etudiants', function (Blueprint $table) {
            // Ajouter les foreign keys
            $table->foreignId('university_id')->nullable()->constrained('universities')->onDelete('set null');
            $table->foreignId('discipline_id')->constrained('disciplines')->onDelete('cascade');

            // Supprimer les anciens champs string
            $table->dropColumn(['universite', 'discipline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Remettre les anciens champs
            $table->string('universite')->nullable();
            $table->string('discipline');

            // Supprimer les foreign keys
            $table->dropForeign(['university_id']);
            $table->dropForeign(['discipline_id']);
            $table->dropColumn(['university_id', 'discipline_id']);
        });
    }
};
