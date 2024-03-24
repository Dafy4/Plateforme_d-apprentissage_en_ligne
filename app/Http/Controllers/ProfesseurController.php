<?php

namespace App\Http\Controllers;

use App\Http\Requests\matiere as RequestsMatiere;
use App\Models\Categorie;
use App\Models\Chat;
use App\Models\Commentaire;
use App\Models\Contenu_du_cour;
use App\Models\Contenu_du_cour_etudiant;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Proffesseur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class ProfesseurController extends Controller
{
    public function accueil()
    {
        return view('professeur.accueil', [
            'matieres' => Matiere::where('proffesseur_id', Auth::user()->professeur->id)->get()
        ]);
    }

    //View création de matières
    public function CreationMatiereRedirect()
    {
        return view('professeur.CreerMatiere', [
            'category' => Categorie::all()
        ]);
    }

    public function storeMatiere(Request $request)
    {
        //Créer par défaut le contenu du cours de la matière
        $contenu_du_cour = Contenu_du_cour::create([
            'contenue'      => '[]',
            'sujet_examen'  => json_encode([
                'examen'=>[],
                'temps'=>'3600'
            ]),
            'niveau'        => 1
        ]);

        //Créer la nouvelle matière
        $matiere = Matiere::create([
            'matiere'               =>  $request->input('matiere'),
            'contenu_du_cour_id'    =>  $contenu_du_cour->id,
            'categorie_id'          =>  $request->input('categorie_id'),
            'proffesseur_id'        =>  Auth::user()->professeur->id,
            'description'           =>  $request->input('description'),
            // 'description' => $request->input('description')
        ]);
        $matiere->contenu_du_cours()->sync($contenu_du_cour->id);

        return redirect()->route('professeur.accueil', [
            'matieres' => Matiere::where('proffesseur_id', Auth::user()->professeur->id)->get()
        ])->with('success', 'Nouvelle matière ajoutée avec succès');
    }

    //Ajout catégorie
    public function ajoutCategorie()
    {
        return view('professeur.ajoutCategorie', [
            'category' => Categorie::all()
        ]);
    }
    public function storeCategorie(Request $request)
    {
        Categorie::create([
            'categorie' => $request->input('categorie')
        ]);
        return redirect()->route('professeur.creationMatiere')->with('success', 'Nouvelle catégorie enregistrée');
    }

    public function CreationCoursRedirect()
    {

        return view('professeur.creationCours');
    }

    public function store(Request $request)
    {
        $prof = User::find(Auth::user()->id);
        // $id=$prof->find_prof[0]->id;

        $id=$prof->professeur->id;
        Contenu_du_cour::create([
            'contenue' => '[]',
            'sujet_examen' => json_encode([
                'examen'=>[],
                'temps'=>'3600'
            ]),
            'niveau' => 1
        ]);


        $matiere=Matiere::create([
            'matiere' => $request->input('matiere'),
            'proffesseur_id' => $id
        ]);
        return view('professeur.accueil', [
            'matieres' => Matiere::where('proffesseur_id', Auth::user()->professeur->id)->get()
        ]);
    }

    public function cours(Request $request)
    {
        $cour=Contenu_du_cour::find(6);
        $cour->contenue = $request->input('cours');
        $cour->save();
        return "Cours enregistré avec succèes";
    }

    //Création de contenu de cours
    public function createRedirect(Matiere $matiere, String $contenu)
    {
        return view('professeur.creationCours',[
            'matiere' => $matiere,
            'content' => $contenu
            // 'matiere' => Matiere::with('contenu_du_cours')
        ]);
    }
    public function createExamenRedirect(Matiere $matiere, String $contenu){
        return view('professeur.creationExamen',[
            'matiere' => $matiere,
            'content' => $contenu
            // 'matiere' => Matiere::with('contenu_du_cours')
        ]);
    }

    //Affichage des contenus de cours par matière
    public function affichageCours(Matiere $matiere, String $contenu)
    {
        return view('professeur.affichageCours',[
            'matiere' => $matiere,
            'content' => $contenu
        ]);
    }
    //Ajout niveau
    public function ajoutRedirect(Matiere $matiere)
    {
       $niveau = $matiere->contenu_du_cours()
        ->orderBy('contenu_du_cours.created_at', 'desc')
        ->select('niveau')
        ->first();

        // dd();
        $niv = (int)$niveau->niveau;
        $niv++;
        if($niv >= 1 || $niv <= 5 )
        {
            $contenu_du_cour = Contenu_du_cour::create([
                'contenue' => '[]',
                'sujet_examen'  => json_encode([
                    'examen'=>[],
                    'temps'=>'3600'
                ]),
                'niveau'  => $niv
            ]);
            $matiere->contenu_du_cours()->attach($contenu_du_cour->id);
            // return ($contenu_du_cour);
        }
        return view('professeur.accueil', [
            'matieres' => Matiere::where('proffesseur_id', Auth::user()->professeur->id)->get()
        ])->with('success', 'Niveau supérieur ajouté');
    }
    //Profil

    public function profilRedirect(Proffesseur $professeur)
    {
        return view('professeur.profil', [
            'professeur' => $professeur
        ]);
        // return view('professeur.profil')->with('professeur',$professeur);
    }

    //Reset password
    public function resetPassword()
    {
        return 'ok';
    }
    public function updateCours(Request $request,Contenu_du_cour $contenue)
    {
        $cour=Contenu_du_cour::find($contenue->id);
        $cour->contenue = $request->input('cours');
        $cour->save();
        return "Cours enregistré avec succèes";
    }
    public function getCours(Contenu_du_cour $contenue ,int $a){
        $cours=json_decode($contenue->contenue);
        if(Auth::user()->type_user=='etudiants'){
            $info1= Contenu_du_cour_etudiant::where('etudiant_id','=',Auth::user()->type('etudiants')->id)->get()[0];
            if($a==1){
                $info1->progression++;
                $info1->save();
            }
            $i=0;
            for($c=0;$c!=count($cours);$c++){
                for($p=0;$p!=count($cours[$c]->partie);$p++){
                    if($i >= intval($info1->progression)){
                        $cours[$c]->partie[$p]='';
                    }
                    $i++;
                }
            }
        }
        return $cours;
    }
    public function updateExam(Request $request,Contenu_du_cour $contenue)
    {
        $cour=Contenu_du_cour::find($contenue->id);
        $cour->sujet_examen = json_encode([
            'examen'=>$request->input('cours'),
            'temps'=>$request->input('temps')
        ]);
        $cour->save();
        return "Cours enregistré avec succèes";
    }
    public function getExam(Contenu_du_cour $contenue){
        return $contenue->sujet_examen;
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
    public function etudiantCours(String $contenu)
    {
        $data=[];
        $etudiants= Contenu_du_cour_etudiant::where('contenu_du_cour_id','=',$contenu)->get(['etudiant_id','reponse_examen','note']);
        foreach($etudiants as $etudiant){
            array_push($data,[
                'id'=>$etudiant->etudiant_id,
                'nom'=>Etudiant::find($etudiant->etudiant_id)->nom,
                'reponse'=>json_decode($etudiant->reponse_examen),
                'note'=>$etudiant->note
            ]);
        }
        return $data;
    }
    public function corrigerExamen(Matiere $matiere, String $contenu){
        return view('professeur.corrigerExamen',[
            'matiere' => $matiere,
            'content' => $contenu
        ]);
    }
}
