<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'departement_id'
    ];

    //Un étudiant appartient à un département
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function contenu_du_cours()
    {
        return $this->belongsToMany(Contenu_du_cour::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}

