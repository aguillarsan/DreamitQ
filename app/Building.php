<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
	//Este modelo hace referencia a la tabla donde se registran los edificios
    protected $table    = 'buildings';
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

}
