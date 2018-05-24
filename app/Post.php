<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable =[
    	'title',
    	'content',
    	'viewed',
    	'user_id',
    	'course_id',
    ];

    public function user(){//Un post pertenece a un usuario
    	return $this->belongsTo(User::class);
    }

    public function comments(){//Un post tiene muchos comentarios
    	return $this->hasMany(Comment::class);
    }

    public function photos(){//Un post tiene muchas fotos
    	return $this->hasMany(Photo::class);
    }

    public function course(){//Un post pertenece a un curso
    	return $this->belongsTo(Course::class);
    }
}
