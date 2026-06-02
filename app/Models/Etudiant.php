<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etudiant extends Model
{
       use HasFactory;

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