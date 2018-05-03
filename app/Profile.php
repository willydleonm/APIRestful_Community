<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable =[
    	'birth_date',
    	'email',
    	'photo',
    	'user_id',
    ];


    public function user(){//Un perfil pertenece a un usuario
    	return $this->belongsTo(User::class);
    }
}
