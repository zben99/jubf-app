<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etudiant extends Model
{
       use HasFactory;

protected $fillable = [
    'nom', 'prenom', 'date_naissance', 'telephone',
    'universite', 'statut', 'discipline', 'photo_path', 'code'
];
}
