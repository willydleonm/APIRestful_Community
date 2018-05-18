<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
    	'content',
    	'date',
    	'post_id',
    	'user_id',
    ];

    public function user(){//Un comentario pertenece a un usuario
    	return $this->belongsTo(User::class);
    }
}
