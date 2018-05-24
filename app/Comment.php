<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $fillable =[
    	'content',
    	'post_id',
    	'user_id',
    ];

    public function user(){//Un comentario pertenece a un usuario
    	return $this->belongsTo(User::class);
    }
}
