<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Administrateur;
use App\Models\User;
use App\Models\Niveau;
use App\Models\Proffesseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        // $a=User::find(2);
        // $a->password=Hash::make('aa');
        // $a->save();
        // $admin = Administrateur::create([
        //     'email' => 'angevoni@gmail.com',
        //     'post' => 'admin'
        // ]);
        // User::create([
        //     'name' => 'Voni',
        //     'email' => 'voni@gmail.com',
        //     'password' => Hash::make('admin'),
        //     'type_user' => 'admin',
        //     'administrateur_id' => $admin->id,
        //     'approved' => true
        // ]);
        // Auth::logout();
        return view('login.auth');
    }

    public function doLogin(LoginRequest $request)
    {
        //L'utilisateur peut se connecter soit avec son email soit avec son username
       $field = filter_var($request->input('email_or_name'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
       $credentials = [
            $field => $request ->input('email_or_name'),
            'password' => $request->input('password'),
       ];
    //    dd($credentials);
            if(Auth::attempt([$field => $credentials[$field], 'password' => $credentials['password']]))
            {

                // Si le compte utilisateur a été approuvé
                if(Auth::user()->approved == true)
                {
                    $request->session()->regenerate();
                    $type_user = Auth::user()->type_user;

                    // GESTION D'UTILISATEUR
                    if($type_user === 'admin')
                    {
                        return redirect()->intended(route('admin.accueil'));
                    }
                    else if($type_user === 'etudiants')
                    {
                        return redirect()->intended(route('etudiant.accueil'));
                    }
                    else if($type_user === 'professeur')
                    {
                        return redirect()->intended(route('professeur.accueil'));
                    }
                    return redirect()->intended(route('test.redirect'));
                } //Sinon, s'il le compte n'est pas encore approuvé
                else if(Auth::user()->approved == false)
                {
                    Auth::logout();
                    return redirect()->route('auth.login')->withErrors([
                        'password' => 'Votre compte n\'est pas encore approuvé'
                    ])->onlyInput('password');
                }
            }
                    return to_route('auth.login')->withErrors([
                        'password' => 'Email ou password invalide'
                    ])->onlyInput('password');
 }

    public function logout()
    {
        Auth::logout();
        return to_route('accueil');
    }
}
