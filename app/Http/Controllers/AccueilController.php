<?php

namespace App\Http\Controllers;

use App\Http\Requests\EngagerProf;
use App\Mail\VerificationEmail;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Proffesseur;
use App\Models\Departement;
use App\Models\User;
use App\Models\Administrateur;
use App\Models\Contenu_du_cour;
use App\Models\Contenu_du_cour_etudiant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccueilController extends Controller
{
    public function redirection()
    {
        // // Création compte admin par défaut
        // $post = Administrateur::create([
        //     'email' => 'angevoni@gmail.com',
        //     'post'=> 'stagiaire'
        // ]);
        // User::create([
        //     'name' => 'Voni',
        //     'email' => $post->email,
        //     'type_user' => 'admin',
        //     'password' => Hash::make('metyy'),
        //     'administrateur_id'=> $post->id
        // ]);

        // Departement::create([
        //     'nom' => 'Service client',
        // ]);

        // si l'utilisateur est deja connecter
        if(auth()->check()){
            $type_user=Auth::user()->type_user;
            if($type_user=="professeur"){
                return redirect()->intended(route('professeur.accueil'));
            }else if($type_user=="admin"){
                return redirect()->intended(route('admin.accueil'));
            }else if($type_user=="etudiants"){
                return redirect()->intended(route('etudiant.accueil'));
            }
        }
        // si l'utilisateur n'est pas connecter
        return view('accueil.home');
    }

    //Show leçons hors connexion
    public function showLesona()
    {
        return view('accueil.lecon', ['matieres' => Matiere::all()] );
    }
    // public function video()
    // {
    //     return Auth::user()->supprimmType();
    // }

    public function createAccount()
    {
        // Departement::create([
        //     'nom' => ' Service Client'
        // ]);
        return view('accueil.inscription');
    }

    public function getDepartement(){
        return Departement::all();
    }

    // Création de compte
    public function storeAccount(Request $request)
    {
        $type_user = $request->input('type_user');
        //GESTION DE DOUBLONS DES UTILISATEURS
        $existingUser = User::where('email', $request->input('email'))->first();
        if($existingUser)
        {
            //Le doublon existe
            return 'Un utilisateur déjà inscrit possède le même email. Veuillez utiliser un autre email ';
        }
        else
        {
            if($type_user == 'professeur')
            {
                // $post = Proffesseur::create($request->validated());

                $post = Proffesseur::create([
                    'nom' => $request->input('nom'),
                    'prenom' => $request->input('prenom'),
                    'telephone' => $request->input('telephone'),
                    'email' => $request->input('email'),
                ]);
                $user = User::create([
                    'name' => $request->input('nom'),
                    'email' => $request->input('email'),
                    'type_user' => 'professeur',
                    'password' => Hash::make($request->input('email')),
                    'proffesseur_id'=> $post->id,
                    'email_verification_token' =>bin2hex(openssl_random_pseudo_bytes(20)), //Génère le token
                ]);
                event(new Registered($user));

                //Envoie du lien de vérification d'email avec le token générer
                $verificationLink = route('verify.email', ['token' => $user->email_verification_token]);
                Mail::to($user->email)->send(new VerificationEmail($verificationLink));

            }
            else if($type_user == 'etudiants')
            {
                $post = Etudiant::create([
                    'nom' => $request->input('nom'),
                    'prenom' => $request->input('prenom'),
                    'telephone' => $request->input('telephone'),
                    'email' => $request->input('email'),
                    'departement_id'=> $request->input('departement'),

                ]);
                $user = User::create([
                    'name' => $request->input('nom'),
                    'email' => $request->input('email'),
                    'type_user' => 'etudiants',
                    'password' => Hash::make($request->input('email')),
                    'etudiant_id'=> $post->id,
                    'email_verification_token' =>bin2hex(openssl_random_pseudo_bytes(20)), //Génère le token
                ]);

                event(new Registered($user));

                //Envoie du lien de vérification d'email avec le token générer
                $verificationLink = route('verify.email', ['token' => $user->email_verification_token]);
                Mail::to($user->email)->send(new VerificationEmail($verificationLink));

            }
            else if($type_user == 'admin'){
                $post = Administrateur::create([
                    'email' => $request->input('email'),
                    'post'=> $request->input('post')
                ]);
                $user = User::create([
                    'name' => $request->input('nom'),
                    'email' => $request->input('email'),
                    'type_user' => 'admin',
                    'password' => Hash::make($request->input('email')),
                    'administrateur_id'=> $post->id,
                    'email_verification_token' =>bin2hex(openssl_random_pseudo_bytes(20)), //Génère le token
                ]);

                event(new Registered($user));

                //Envoie du lien de vérification d'email avec le token générer
                $verificationLink = route('verify.email', ['token' => $user->email_verification_token]);
                Mail::to($user->email)->send(new VerificationEmail($verificationLink));
            }

            return "Votre compte a bien été crée, vous devriez attendre l'approbation de l'admin, un email de vérification vous a été envoyé";// return redirect()->route('accueil')->with("success", "Votre compte a bien été crée, vous devriez attendre l'approbation de l'admin");

        }

    }
}
