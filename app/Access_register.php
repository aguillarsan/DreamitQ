<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access_register extends Model
{
	//Este modelo hace referencia a la tabla donde se registran los accesos de los usuairos a los edificios
	 protected $table = 'access_resgister';
     protected $fillable = [
        'user_id', 'building_id'
    ];


}
