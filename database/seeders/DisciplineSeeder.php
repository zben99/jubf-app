<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Seeder;

class DisciplineSeeder extends Seeder
{
    public function run(): void
    {
        $disciplines = [
            'Théâtre',
            'Orchestre',
            'Chanson moderne',
            'Chanson traditionnelle',
            'Slam',
            'Danse traditionnelle',
            'Conte',
            'Humour',
            'Art oratoire',
            'Art culinaire',
            'Scrabble',
            'Awalé',
            'Damier',
            'Pétanque',
            'Culture générale',
            'Handi-sport',
            'Athlétisme',
            'Lutte',
        ];

        foreach ($disciplines as $name) {
            Discipline::firstOrCreate(['name' => $name]);
        }
    }
}
