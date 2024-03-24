<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu_du_cour extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenue',
        'sujet_examen',
        'niveau'
    ];
    public function commentaire(){
        return $this->belongsToMany(Commentaire::class);
    }
    public function etudiant()
    {
        return $this->belongsToMany(Etudiant::class);
    }
    public function matiere()
    {
        return $this->belongsToMany(Matiere::class);
    }
    public function nbProgression(){
        $cours=json_decode($this->contenue);
        $nb=0;
        for($c=0;$c!=count($cours);$c++)
        {
            for($p=0;$p!=count($cours[$c]->partie);$p++)
            {
                $nb++;
            }
        }
        return $nb;
    }
    public function sujetEtudient(){
        $reponse=[];
        $examenn=json_decode(json_decode($this->sujet_examen)->examen);
        $temps=json_decode($this->sujet_examen)->temps;
        foreach ($examenn as $exam){
            if($exam->type=='sujet'){
                array_push($reponse,$exam);
            }else if($exam->type=='question'){
                if($exam->type1=='text'){
                    $exam->reponse=null;
                    array_push($reponse,$exam);
                }else if($exam->type1=='quiz'){
                    foreach ($exam->choix as $choix){
                        $choix->reponse=false;
                    }
                    array_push($reponse,$exam);
                }else{
                    array_push($reponse,$exam);
                }
            }
        }
        return [
            'examen'=>$reponse,
            'temps'=>$temps
        ];
    }

}
