<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'post'
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
