<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable =[
    	'birth_date',
    	'email',
    	'photo',
    	'user_id',
    ];

    public function setEmailAttribute($value){
    	$this->attributes['email']= strtolower($value);
    }

    public function user(){//Un perfil pertenece a un usuario
    	return $this->belongsTo(User::class);
    }
}
