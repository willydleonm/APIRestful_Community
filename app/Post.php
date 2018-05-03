<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =[
    	'title',
    	'content',
    	'created_date',
    	'edited_date',
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
