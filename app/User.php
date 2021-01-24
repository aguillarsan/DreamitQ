<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	//Este modelo hace referencia a la tabla donde se registran los usuarios
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'rut', 'last_name', 'blocked',
    ];

    public function building()
    {
        return $this->belongsToMany(Building::class);
    }
}
