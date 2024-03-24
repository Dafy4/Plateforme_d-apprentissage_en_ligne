<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfilUserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\testController;
use App\Http\Controllers\VerificationController;
use App\Models\Departement;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Accueil principal
Route::get('/', [AccueilController::class, 'redirection'])->name('accueil');
Route::get('/video', [AccueilController::class, 'video'])->name('video');
Route::get('/Leçons existantes', [AccueilController::class, 'showLesona'])->name('accueil.lecon');

//Changer la photo de profil
Route::get('Changer votre photo de profil', [ProfilUserController::class, 'changeProfilPictureRedirect'])->name('changeProfilPictureRedirect');
Route::post('Changer votre photo de profil', [ProfilUserController::class, 'storeProfilPicture'])->name('profil.store');

//Création de compte
Route::get('/account', [AccueilController::class, 'createAccount'])->name('create.account');
Route::post('/account', [AccueilController::class, 'storeAccount']);
Route::get('/departement', [AccueilController::class, 'getDepartement']);

//AUTHENTIFICATION
Route::prefix('authentification')->name('auth.')->controller(AuthController::class)->group(function(){
    Route::get('/', 'login')->name('login');
    Route::post('/', 'doLogin');
});

//TEST
Route::get('/test', [testController::class, 'testRedirect'])->name('test.redirect');

//DECONNEXION
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');

//INTERFACE ADMINISTRATEUR
Route::prefix('/Interface administrateur')->name('admin.')->controller(AdminController::class)->group(function(){
    Route::get('/', 'accueil')->name('accueil');
    Route::get('/Informations utilisateurs', 'consulter')->name('utilisateurs');
    // Route::post('/Espace professeur', 'insertion');

    //APPROBATION D'UN COMPTE UTILISATEUR
    Route::get('/Gestion de compte utilisateur', 'gestionCompteRedirect')->name('gestionCompte');
    // Route::patch('/Gestion de compte utilisateur', 'approuver');
    Route::get('{user}/Gestion d\'utilisateur', 'rediRectApprouver')->name('approuver');
    Route::patch('{user}/Gestion d\'utilisateur', 'approuver');
    Route::get('{user}-{type}-{idDepart}/changement', 'changeTypeUser')->name('changeTypeUser');
    Route::get('{user}/suppreUser', 'suppreUser')->name('suppreUser');

    //AFFICHAGE ET GESTION DE LA VISIBILITE DES COURS
                //Affiche toutes les matières existantes
    Route::get('/Cours/Listes', function(){
        return view('admin.cours', [
            'matieres' => Matiere::all(),
        ]);
    })->name('cours');
    Route::get('Cours/{matiere}/{contenu}', 'affichageCours')->name('affichageCoursAdmin');

                //Retourne la vue pour le choix des département à bénéficier des cours
    Route::get('Coursdep/{cours}/Visibilité par département', 'ViewVisibiliteCours')->name('visibiliteCours');
    Route::post('Coursdep/{cours}/Visibilité par département', 'storeDepartementMatiere');

    //Affichage des notes des étudiants par ordre croissant dans l'interface admin
    Route::get('Résultats', 'showResultats')->name('resultats');

    //Gère les requêttes AJAX pour filtrer les informations par utilisateurs
    Route::get('/users/filtre/type_user/{type_user}', 'filtrerUtilisateurs');

    //Gère les informations par département
    Route::get('Départements', 'showDepartement')->name('departement');
    Route::post('Départements', 'storeDepartement');
    Route::get('Départements/{departement}', 'consulterDepartement')->name('depConsulter');
    Route::get('Départements/supprimé/{departement}', 'supprimeDepartement')->name('supprimeDepartement');


    //Filtre les cours ou matières affichées dans l'onglet resultat
    Route::get('/Résultats/filtreCours/{cours}', 'filtrerCoursResultats')->name('filtrerResutats');
});

//INTERFACE PROFESSEUR
Route::prefix('/Interface professeur')->name('professeur.')->controller(ProfesseurController::class)->group(function(){
    Route::get('/', 'accueil')->name('accueil');

    //Création cours et matières
    Route::get('/Création matiere', 'CreationMatiereRedirect')->name('creationMatiere');
    Route::post('/Création matiere', 'storeMatiere');

    //Création de contenu de cours
    Route::get('{matiere}-{contenu}/Création contenu de cours', 'createRedirect')->name('creationCours');
    Route::get('{matiere}-{contenu}/Création contenu de cours/examen', 'createExamenRedirect')->name('creationExamen');
    //mise a jour de contenue du cours creationExamen
    //Interface%20professeur/Cr%C3%A9ation%20contenu/13
    Route::get('{contenue}-{a}/pogression', 'getCours');
    Route::get('{contenue}-{a}/Création contenu', 'getCours');
    Route::post('{contenue}/Création contenu', 'updateCours');
    Route::get('{contenue}/Création exam', 'getExam');
    Route::post('{contenue}/Création exam', 'updateExam');

    // Route::post('/Création contenu', 'cours');

    //Ajout niveau
    Route::get('{matiere}/Ajouter un niveau', 'ajoutRedirect')->name('ajoutNiveau');

    //Ajout categorie
    Route::get('/Ajout categorie', 'ajoutCategorie')->name('ajoutCategorie');
    Route::post('/Ajout categorie', 'storeCategorie');

    //Profil
    Route::get('{professeur}/Profil', 'profilRedirect')->name('profil');
    //RESET PASSWORD
    Route::get('{professeur}/Profil/Reset password', 'resetPassword')->name('resetPassword');

    //Affichage des cours par matière
    Route::get('{matiere}-{contenu}/Consulter les cours', 'affichageCours')->name('affichageCours');
    Route::get('{matiere}-{contenu}/Consulter les cours/examen', 'corrigerExamen')->name('corrigerExamen');
    Route::get('{contenu}-{stringId}/commentaire', 'getCommentaire');
    Route::get('{contenu}-{nb}/nbcommentaire', 'getNbCommentaire');
    Route::post('{contenu}/commentaire', 'envoyerCommentaire');

    //AFFICHER LES ETUDIANTS PAR COURS
    Route::get('{contenu}/etudiants', 'etudiantCours');
});

// INTERFACE ETUDIANT
Route::prefix('/Interface étudiant')->name('etudiant.')->controller(EtudiantController::class)->group(function(){
    Route::get('/accueil', 'accueilRedirect')->name('accueil');
    Route::get('matiere', 'showMatiereEtudiant')->name('matiere');
    
    Route::get('{matiere},-{contenu}/Consulter les cours', 'affichageCours')->name('affichageCours');
    Route::get('{contenu}-{stringId}/commentaire', 'getCommentaire');
    Route::get('{contenu}-{nb}/nbcommentaire', 'getNbCommentaire');

    Route::get('{matiere}-{contenu}/Consulter les cours/examen', 'affichageExamen')->name('affichageExamen');

    Route::get('{contenu}/exam', 'getExam')->name('examen');
    Route::post('{contenu}/exam', 'setExam');
    //Profil étudiant
    Route::get('Profil', 'showProfil')->name('profil');

});

//ENVOIE D'EMAIL DE VERIFICATION D'EMAIL D'UTILISATEURS

    //Route qui appelle le controller qui marque la vérification de l'email dans la base de données avec en paramètre le token de l'email pour vérifier l'utilisateur
Route::get('/verify-email/{token}',[VerificationController::class, 'verify'])->name('verify.email');

    //Route qui renvoie un message de succès lorsque l'email est vérifié
Route::get('/verify/email/result-success', function(){
    return 'Email verified';
})->name('verification.success');

    //Route qui renvoie un message de succès lorsque l'email est vérifié
Route::get('/verify/email/result-error', function(){
    return 'Email not verified';
})->name('verification.error');


//RESET PASSWORD

Route::get('/reset-password/',[ResetPasswordController::class, 'showResetForm'])->name('password.request');
Route::post('/reset-password/',[ResetPasswordController::class, 'reset'])->name('password.update');
// Route::get('/reset-password/',[ResetPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.request');
// Route::post('/reset-password/',[ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

//Route après que l'utilisateur ait cliqué sur le lien envoyé dans son email
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

//Après que l'utilisateur ait rempli le formulaire de réinitialisation de mot de passe
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:5|confirmed',
    ]);

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

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('auth.login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

//Route d'envoie d'email de confirmation de changement de mot de passe
Route::get('/verify/email/reset-password-confirmation', [VerificationController::class, 'verifyEmailBeforeChangePassword'])->name('verify.passwordReset');
