<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Administrateur SENAC-UB',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );

        $this->call([
            UniversitySeeder::class,
            DisciplineSeeder::class,
        ]);
    }
}