<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    //Les matières que doivent apprendre les département
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class);
    }

    //Un département est composé de beaucoup d'étudiants
    public function etudiant()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function deleteDepartement()
    {
        return $this->delete();
    }
}
