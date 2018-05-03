<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable =[
    	'url_photo',
    	'post_id',
    ];

    public function post(){//Una foto pertenece a un post
    	return $this->belongsTo(Post::class);
    }
}
