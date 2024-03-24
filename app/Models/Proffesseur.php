<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Proffesseur extends Model implements Authenticatable
{
    use HasFactory;
    use AuthenticableTrait;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

}
