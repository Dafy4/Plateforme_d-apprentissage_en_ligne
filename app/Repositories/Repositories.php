<?php

namespace App\Repositories;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;

class CustomTokenRepository extends DatabaseTokenRepository
{
    protected $column = 'reset_password_token'; // Votre colonne pour les tokens de réinitialisation

    public function getToken($user)
    {
        return $user->{$this->column};
    }

    public function setToken($user, $token)
    {
        $user->{$this->column} = $token;
        $user->save();
    }
}
