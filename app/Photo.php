<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $fillable =[
    	'url_photo',
    	'post_id',
    ];

    public function post(){//Una foto pertenece a un post
    	return $this->belongsTo(Post::class);
    }
}
