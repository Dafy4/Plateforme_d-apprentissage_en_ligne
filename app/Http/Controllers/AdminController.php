<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartementMatiereRequest;
use App\Http\Requests\EngagerProf;
use App\Models\Administrateur;
use App\Models\Contenu_du_cour_etudiant;
use App\Models\Departement;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Proffesseur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function accueil()
    {

        // Matiere::create([
        //     'matiere' => 'francais',
        //     'description' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        // ]);

        // $a=User::find(1);
        // dd($a->professeur->nom);
        // return User::where('approved', false)->get();
        return view('admin.accueil', [
            'trois_derniers_cours'  => Matiere::latest()->take(3)->get(),
            'matieres'    => Matiere::all()
        ]);
        // return Matiere::latest()->take(3)->get();
    }

    public function gestionCompteRedirect(){
        return view('admin.gestionCompteUtilisateur', [
            // Renvoie le nombre d'utilisateurs non approuvés
            'utilisateurs_non_approuve' => User::where('approved', false)->count(),

             // Renvoie le nombre d'utilisateurs approuvés*
            'utilisateurs_approuve' => User::where('approved', true)->count(),

            //Renvoie le nombre d'étudiants inscrits
            'etudiants_inscrits'  => Etudiant::all()->count(),

            //Renvoie le nombre de professeurs inscrits
            'professeurs_engager' => Proffesseur::all()->count(),

            //Renvoie le nombre de administrateurs inscrits
            'administrateurs'  => Administrateur::all()->count(),

            // Renvoie la liste des utilisateurs non approuvés
            'usersData'  => User::where('approved', false)->get(),
        ]);
    }

    public function consulter()
    {
        // $a= Etudiant::all()[0];
        // return $a->departement->matieres;
        return view('admin.utilisateurs', [
            'info_etudiants' => Etudiant::all(),
            'info_professeurs' => Proffesseur::all(),
            'etat' => 'Tous', //L'état de retour des informations
            'departement' => Departement::all(),
        ]);
    }

    public function insertion(EngagerProf $request)
    {
        $post = Proffesseur::create($request->validated());
        User::create([
            'name' => $request->input('nom'),
            'email' => $request->input('email'),
            'type_user' => 'professeur',
            'password' => Hash::make($request->input('email')),
            'proffesseur_id	' => $post->id
        ]);
        // $user_id = User::latest()->first()->id;
        // $post->user_id = $user_id;
        // $post->save();
        return redirect()->route('admin.accueil')->with("success", "L'article a bien été sauvegardé");
    }

    //APPROBATION D'UN COMPTE UTILISATEUR
    public function rediRectApprouver(User $user)
    {
        return view('admin.infoUser',[
            'user' => $user,
            'type_user' => $user->type_user
        ]);
    }
    public function approuver(User $user)
    {
        // return 'ok';
        $user->update(['approved' => true]);
        return redirect()->route('admin.gestionCompte')->with("success", "L' utilisateur a bien été approuvé");
    }

    //Retourne la vue pour le choix de la visibilité de chaque cours par département
    public function ViewVisibiliteCours(Matiere $cours){
        // Departement::create([
        //     'nom'  => 'Marketing',
        // ]);
        return view('admin.visibiliteCours', [
            'cours'         => $cours,
            'departements'  => Departement::select('id', 'nom')->get(), //Séléctionne l'id et le nom de chaque département
        ]);
    }

    //Stocke les matières et les départements associés
    public function storeDepartementMatiere(Matiere $cours, DepartementMatiereRequest $request)
    {
        // dd( $request->input('departement'));
        $cours->departement()->sync($request->validated('departement'));
        return redirect()->route('admin.cours')->with("success", "Modification effectuée");
    }

    //Afficher les notes par ordre croissant
    public function showResultats()
    {
        //Récupérer les notes par ordre croissant
        $notes = Contenu_du_cour_etudiant::orderBy('note')->get();
        $etudiants=[];
        foreach($notes as $note)
        {
            if($note->note > -1){
                array_push($etudiants,[
                    'etudiant'=>Etudiant::find($note->etudiant_id),
                    'note'=> $note->note
                ]);
            }
        }
        // return $etudiants[0]['etudiant']->contenu_du_cours ;
        return view('admin.resultats', ['etudiants' => $etudiants, 'matieres' => Matiere::all()]);
    }

    //Fonction qui permet de filtrer les utilisateurs selon leur type
    public function filtrerUtilisateurs(string $type_user)
    {
        //Récupère l'utilisateur
        $user = User::where('type_user', '=', $type_user)->get();

        //Retourner les informations sous forme de json
        // return response()->json(view('admin.utilisateurs', compact('user'))->render());
        return $user;
        // return response()->json(view('test.test', compact('user'))->render());
    }

    //Affichage cours
    public function affichageCours(Matiere $matiere, String $contenu)
    {
        // return Auth::user()->type('etudiants')->contenu_du_cours->find($contenu);
        // return Auth::user()->type('etudiants')->id;

        // test1
        // return $matiere->progression(Auth::user()->type('etudiants'));
        // test2
        // return $matiere->progression();

        return view('admin.cours',[
            'matiere' => $matiere,
            'content' => $contenu
        ]);

    }

    //Filtrer les résultats par cours
    public function filtrerCoursResultats(Matiere $cours)
    {
        $contenu_cours = $cours->contenu_du_cours;
        // return Contenu_du_cour_etudiant::find($contenu->id) ;
        foreach($contenu_cours  as  $contenu)
        {
            // return Contenu_du_cour_etudiant::find($contenu->id) ;
            // return Contenu_du_cour_etudiant::where('contenu_du_cour_id', '=', '1');
        }


    }

    public function changeTypeUser(User $user,string $type,int $idDepart){
        if(Auth::user()->type_user=='admin'){
            if($type=='etudiants'){
                $etudiant = Etudiant::create([
                    'nom' => $user->name,
                    'prenom' => $user->name,
                    'telephone' => 034232223,
                    'email' => $user->email,
                    'departement_id'=> $idDepart,
                ]);
                $etudiant->save();
                $user->supprimmType();
                $user->delete();
                User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'type_user' => $type,
                    'password' => Hash::make($user->email),
                    'etudiant_id'=> $etudiant->id
                ]);
            }
            if($type=='admin'){
                $admin = Administrateur::create([
                    'email' => $user->email,
                    'post'=> "_"
                ]);
                $admin->save();
                $user->supprimmType();
                $user->delete();
                User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'type_user' => $type,
                    'password' => Hash::make($user->email),
                    'administrateur_id'=> $admin->id
                ]);
            }
            if($type=='professeur'){
                $prof = Proffesseur::create([
                    'nom' => $user->name,
                    'prenom' => $user->name,
                    'telephone' => '03678998779',
                    'email' => $user->email,
                ]);
                $prof->save();
                $user->supprimmType();
                $user->delete();
                User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'type_user' => $type,
                    'password' => Hash::make($user->email),
                    'proffesseur_id'=> $prof->id
                ]);
            }
            return redirect()->route('admin.utilisateurs')->with("success", "Type d'utilisateur modifier avec succes");
        }
    }
    public function suppreUser(User $user){
        $user->supprimmType();
        $user->delete();
        return redirect()->route('admin.utilisateurs')->with("success", "compte supprimé avec succes");
    }

    //Gestion de départements
    public function showDepartement()
    {
        return view('admin.departement', ['departements' => Departement::all()]);
    }
    public function storeDepartement(Request $request)
    {
        Departement::create([
            'nom' => $request->input('departement')
        ]);
        return redirect()->route('admin.departement')->with("success", "Nouveau département ajouté");
    }
    public function consulterDepartement(Departement $departement)
    {
        return view('admin.departement', ['departements' => $departement]);
    }
    public function supprimeDepartement(Departement $departement)
    {
        $nomDepartement = $departement->nom;
        $departement->deleteDepartement();
        return redirect()->route('admin.departement')->with("success", "Département ".$nomDepartement." supprimé");
    }
}
