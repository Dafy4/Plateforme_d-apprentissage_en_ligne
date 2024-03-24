<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'comentaires',
        'user_id'
    ];
    public function contenu_du_cours(){
        return $this->belongsToMany(Contenu_du_cour::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    /**
    * Les attributs à ajouter au tableau JSON.
    *
    * @var array
    */
    protected $appends = ['nom_utilisateur'];
   /**
     * Obtenez l'attribut user_name.
     *
     * @return string
     */
    public function getNomUtilisateurAttribute()
    {
        return $this->user->name;
    }
    /**
     * Convertir le modèle en tableau.
     *
     * @return array
     */
    public function toArray()
    {
        return parent::toArray();
    }
}
