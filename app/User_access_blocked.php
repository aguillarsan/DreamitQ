<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_access_blocked extends Model
{
	//Este modelo hace referencia a la tabla donde se registra si el usuario puede acceder o no a un edificio
    protected $table = 'user_access_blocked';

    protected $fillable = [
        'user_id', 'building_id','blocked'
    ];



    public function building(){

        return $this->belongsTo(Building::class);
    }

}
