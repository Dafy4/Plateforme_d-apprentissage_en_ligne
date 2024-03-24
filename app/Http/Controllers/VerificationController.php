<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Mail\ResetPasswordEmail;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class VerificationController extends Controller
{
    public function verify($token)
    {
        // Trouver l'utilisateur correspondant au token dans la base de données
        $user = User::where('email_verification_token', $token)->first();

        if ($user) {
            // Marquer l'utilisateur comme ayant vérifié son e-mail
            $user->email_verified_at = now(); // Utilisation de Laravel pour marquer l'e-mail comme vérifié
            $user->email_verification_token = null; // Effacer le token de vérification
            $user->save();

            // Redirection vers une page de succès ou un message de succès
            return redirect()->route('verification.success');
        }

        //Si l'adresse email est introuvable
        if (!$user) {
            return back()->withErrors(['email' => 'Adresse e-mail introuvable']); // Retourne une erreur vers la vue précédente
        }

        // Redirection vers une page d'échec ou un message d'échec
        return redirect()->route('verification.error');
    }

    public function verifyEmailBeforeChangePassword()
    {
        $user = User::find(Auth::user()->id);
        // $user->reset_password_token = bin2hex(openssl_random_pseudo_bytes(20));//Génère le token
        $token = Password::createToken($user);
        $user->reset_password_token = $token;
        $user->save();
        //Le lien envoyé dans l'email de l'utilisateur qui le redirigera vers le formulaire de changement de mot de passe
        // $resetPasswordLink = route('password.request', ['token' => $user->reset_password_token]);
        $resetPasswordLink = route('password.request', ['token' =>  $token]);

        Mail::to($user->email)->send(new ResetPassword($resetPasswordLink));

        return back()->with('success','An email has been sent' );
    }
}
