<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $universities = [
            ['name' => 'USTA', 'acronym' => 'USTA'],
            ['name' => 'ISSDH', 'acronym' => 'ISSDH'],
            ['name' => 'Centre Universitaire de Manga', 'acronym' => 'CU-MANGA'],
            ['name' => 'Université Yembila Abdoulaye Toguyeni/Fada', 'acronym' => 'UYAT/FADA'],
            ['name' => 'Université Norbert Zongo', 'acronym' => 'UNZ'],
            ['name' => 'Université Nazi Boni', 'acronym' => 'UNB'],
            ['name' => 'Centre Universitaire de Gaoua', 'acronym' => 'CU-GAOUA'],
            ['name' => 'Centre Universitaire de Banfora', 'acronym' => 'CU-BANFORA'],
            ['name' => 'Université Privée Baba Coulibaly', 'acronym' => 'UPBC'],
            ['name' => 'Centre Universitaire de Kaya', 'acronym' => 'CU-KAYA'],
            ['name' => 'Université Thomas Sankara', 'acronym' => 'UTS'],
            ['name' => 'Centre Universitaire de Tenkodogo', 'acronym' => 'CU-TENKODOGO'],
            ['name' => 'Université Léda Bernard Ouédraogo de Ouahigouya', 'acronym' => 'ULBO'],
            ['name' => 'Université Daniel Ouezzin Coulibaly de Dédougou', 'acronym' => 'UDOC'],
            ['name' => 'ESUP-Jeunesse', 'acronym' => 'ESUP'],
            ['name' => 'École Normale Supérieure (ENS/Ouaga)', 'acronym' => 'ENS-OUAGA'],
            ['name' => 'Université Virtuelle du Burkina Faso', 'acronym' => 'UVBF'],
            ['name' => 'Institut Supérieur de Management de Koudougou', 'acronym' => 'ISMK'],
            ['name' => 'École Normale Supérieure (ENS/Koudougou)', 'acronym' => 'ENS-KOUDOUGOU'],
            ['name' => 'Université Auben-Bobo', 'acronym' => 'AUBEN-BOBO'],
            ['name' => 'Institut Supérieur de Technologies Appliquées et de Management', 'acronym' => 'ISTAPEM'],
            ['name' => 'UMET Burkina', 'acronym' => 'UMET'],
            ['name' => 'Centre Universitaire de Dori', 'acronym' => 'CU-DORI'],
            ['name' => 'École Polytechnique de Ouagadougou', 'acronym' => 'EPO'],
            ['name' => 'IST/Wayalghin', 'acronym' => 'IST/WAYALGHIN'],
            ['name' => 'Centre Universitaire de Ziniaré', 'acronym' => 'CU-ZINIARE'],
        ];

        foreach ($universities as $university) {
            University::firstOrCreate(['acronym' => $university['acronym']], $university);
        }
    }
}
