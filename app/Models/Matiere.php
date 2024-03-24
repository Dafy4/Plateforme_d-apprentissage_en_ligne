<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'matiere',
        'categorie_id',
        'proffesseur_id',
        'description'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function proffesseur()
    {
        return $this->belongsTo(Proffesseur::class);
    }

    public function contenu_du_cours()
    {
        return $this->belongsToMany(Contenu_du_cour::class);
    }
    
    public function departement()
    {
        return $this->belongsToMany(Departement::class);
    }

    //Méthode qui retourne la progression d'un étudiant sur un contenu
    public function progressionContenu_du_cour(Etudiant $etudiant)
    {
        $info1= Contenu_du_cour_etudiant::where('etudiant_id','=',$etudiant->id)->get();
        if(count($info1)==0){
            return 0;
        }
        return $info1[0]->progression;
    }

    //Retourne la totalité des nombres des contenus
    public function progression(){
        foreach($this->contenu_du_cours as $cour)
        {
            $cours=json_decode($cour->contenue);
            $i=0;
            for($c=0;$c!=count($cours);$c++)
            {
                for($p=0;$p!=count($cours[$c]->partie);$p++)
                {
                    $i++;
                }
            }
        }
        return $i;
    }
    public function resultatExamen()
    {
        foreach($this->contenu_du_cours as $cour)
        {
            $note = $cour->note;
        }
        return $note;
    }

}
