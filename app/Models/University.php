<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name',
        'acronym',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
