<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type_user',
        'etudiant_id',
        'proffesseur_id',
        'administrateur_id',
        'approved',
        'email_verification_token',
        'profilImage'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function professeur()
    {
        return $this->belongsTo(Proffesseur::class, 'proffesseur_id');
    }
    public function etudiants()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }
    public function admin()
    {
        return $this->belongsTo(Administrateur::class, 'administrateur_id');
    }
    public function type(String $type)
    {
        if($type=='admin')
        {
            return $this->admin;
        }
        if($type=='professeur')
        {
            return $this->professeur;
        }
        if($type=='etudiants')
        {
            return $this->etudiants;
        }
    }


    //L'utilisateur peut se connecter avec son email ou son nom d'utilisateur
    public function findForPassport($username)
    {
        return $this->where('email', $username)
                    ->orWhere('username', $username)
                    ->first();
    }
    public function supprimmType(){
        $type=$this->type($this->type_user);
        return $type->delete();
    }
}
