<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Contenu_du_cour;
use App\Models\Contenu_du_cour_etudiant;
use App\Models\Departement;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EtudiantController extends Controller
{
    public function accueilRedirect()
    {

        $departement =  Auth::user()->type(Auth::user()->type_user)->departement;
        return view('etudiants.accueil', [
            // 'matieresRecents'=>Matiere::latest()->take(3)->get(),
            'matieresRecents'=>$departement->matieres()->latest()->take(3)->get(),
            // 'matieres' => $departement->matieres,
            'departement' => $departement->nom,
        ]);
    }
    public function affichageCours(Matiere $matiere, String $contenu)
    {
        // return Auth::user()->type('etudiants')->contenu_du_cours->find($contenu);
        // return Auth::user()->type('etudiants')->id;

        // test1
        // return $matiere->progression(Auth::user()->type('etudiants'));
        // test2
        // return $matiere->progression();



        $info1= Contenu_du_cour_etudiant::where('etudiant_id','=',Auth::user()->type('etudiants')->id)->get();
        if(count($info1)==0){
            Contenu_du_cour_etudiant::create([
                'contenu_du_cour_id'=>$contenu,
                'etudiant_id'=>Auth::user()->type('etudiants')->id,
                'reponse_examen'=>json_encode(Contenu_du_cour::find($contenu)->sujetEtudient()),
                'note'=>-1,
                'progression'=>1
            ]);
        }
        return view('etudiants.affichageCours',[
            'matiere' => $matiere,
            'content' => $contenu
        ]);

    }
    public function getExam(Contenu_du_cour $contenu){
        return $contenu->sujetEtudient();
    }
    public function setExam(Request $request,String $contenu){
        $resultat=Contenu_du_cour_etudiant::where('etudiant_id','=',Auth::user()->type('etudiants')->id)->where('contenu_du_cour_id','=',$contenu)->get()[0];
        $resultat->reponse_examen=json_encode([
            'reponse'=>$request->input('reponse'),
            'fenetre'=>$request->input('fenetre')
        ]);
        $resultat->save();
        return 'gg';
    }
    public function getCommentaire(Contenu_du_cour $contenu,string $stringId){
        return ['coms'=>$contenu->commentaire()->where('comentaires','like',$stringId.'%')->get(),'id'=> Auth::user()->id];
    }
    public function getNbCommentaire(Contenu_du_cour $contenu,string $stringId){
        return $contenu->commentaire()->where('comentaires','like',$stringId.'%')->count();
    }
    public function envoyerCommentaire(Contenu_du_cour $contenu,Request $request){
        $coms = Commentaire::create([
            'comentaires'   =>  $request->input('coms'),
            'user_id'       =>  Auth::user()->id
        ]);
        $coms->contenu_du_cours()->sync($contenu);
        return [
            'nom' => Auth::user()->name,
            'comentaires' => $request->input('coms'),
            'user' => true
        ];
    }
    public function affichageExamen(Matiere $matiere,String $contenu){
        $contenue_cours=Contenu_du_cour::find($contenu);
        $progre=Contenu_du_cour_etudiant::where('etudiant_id','=',Auth::user()->type('etudiants')->id)->get()[0]->progression;
        if($contenue_cours->nbProgression()<=$progre){
            return view('etudiants.examen',['content' => $contenu]);
        }else{
            return redirect()->intended(route('etudiant.affichageCours',[
                'matiere' => $matiere,
                'contenu' => $contenu
            ]));
        }

    }

    //Profil étudiant
    public function showProfil()
    {
        $departement =  Auth::user()->type(Auth::user()->type_user)->departement;
        // $matiereEnCoursApprentissage =  $departement->matieres[0]->contenu_du_cours->where('progression', '<' ,1) ;
        $matiereEnCoursApprentissage =  $departement->matieres; 
        // return  $matiereEnCoursApprentissage;
        return view('etudiants.profil', ['etudiant'=> Auth::user()->type('etudiants'), 'matiereEnCours' =>  $matiereEnCoursApprentissage ]);
    }
    public function showMatiereEtudiant()
    {
        $departement =  Auth::user()->type(Auth::user()->type_user)->departement;
        return view('etudiants.matiere', ['matieres' => $departement->matieres]);
    }
}
