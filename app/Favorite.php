<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $fillable =[
    	'post_id',
    	'user_id',
    ];

    public function user(){//Un favorito pertenece a un usuario
    	return $this->belongsTo(User::class);
    }

}
