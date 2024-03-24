<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    // use ResetsPasswords;

    // Affiche le formulaire de réinitialisation de mot de passe
    public function showResetForm(Request $request)
    {
        // Trouver l'utilisateur correspondant au token dans la base de données
        $user = User::where('reset_password_token', $request->token)->first();
        if($user)
        {
            return view('auth.resetPassword')->with([
                'token' =>  $request->token,
                'email' => $request->email,
                'user'  => $user,
                ]
            );
        }
        return 'Utilisateur non reconnu';
    }

    // Réinitialise le mot de passe
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
        ]);

//         $response = Password::broker()->reset(
// $request->only('email', 'password', 'password_confirmation', 'token'),
//             function ($user, $password)
//             {
//                 dd($user);
//                 $this->resetPassword($user, $password);
//             }
//         );
$status = Password::reset(
    $request->only('email', 'password', 'password_confirmation', 'token'),
    function (User $user, string $password) {
        $user->forceFill([
            'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
    }
);
        dd($status);
        // if ($response == Password::PASSWORD_RESET) {
        //     if(Auth::check())
        //     {
        //         Auth::logout();
        //         return redirect()->route('authentification.login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
        //     }
        // }
        // else
        // {
        //     return back()->withErrors(['email' => trans($response)]);
        // }
    }
    public function resetPassword(User $user, string $password)
    {
        // Logique de réinitialisation du mot de passe

        // Exemple d'appel à la méthode resetPassword
        // $user = $request->user();
        $this->actualiserMotDePasse($user, $password);
    }
    private function actualiserMotDePasse($user, $password)
    {
        // Logique de réinitialisation de mot de passe
        $user->password = Hash::make($password);
    }
}
