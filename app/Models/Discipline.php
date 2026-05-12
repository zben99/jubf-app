<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
