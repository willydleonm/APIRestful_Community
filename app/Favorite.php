<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable =[
    	'added_date',
    	'user_id',
    ];

    public function user(){Un favorito pertenece a un usuario
    	return $this->belongsTo(User::class);
    }

}
