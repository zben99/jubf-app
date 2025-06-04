<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Ajoute la colonne 'photo_path', non nullable (obligatoire)
            $table->string('photo_path');

            // Ajoute la colonne 'code' qui doit être UNIQUE
            $table->string('code')->unique()->after('photo_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('photo_path');
        });
    }
};
