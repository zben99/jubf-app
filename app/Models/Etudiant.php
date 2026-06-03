<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etudiant extends Model
{
    use HasFactory, SoftDeletes;

protected $fillable = [
    'nom', 'prenom', 'sexe', 'ine', 'matricule', 'date_naissance', 'telephone',
    'university_id', 'statut', 'discipline_id', 'photo_path', 'code'
];

public function university()
{
    return $this->belongsTo(University::class);
}

public function discipline()
{
    return $this->belongsTo(Discipline::class);
}
}