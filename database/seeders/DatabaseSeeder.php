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
                'name'             => 'Administrateur SENAC-UB',
                'role'             => 'admin',
                'email_verified_at'=> now(),
                'password'         => Hash::make('password'),
                'remember_token'   => Str::random(10),
            ]
        );

        User::firstOrCreate(
            ['email' => 'cenou@senacub.bf'],
            [
                'name'             => 'Utilisateur CENOU',
                'role'             => 'cenou',
                'email_verified_at'=> now(),
                'password'         => Hash::make('cenou2026'),
                'remember_token'   => Str::random(10),
            ]
        );

        $this->call([
            UniversitySeeder::class,
            DisciplineSeeder::class,
        ]);
    }
}