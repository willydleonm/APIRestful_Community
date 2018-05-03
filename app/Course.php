<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable =[
    	'course_name',
    	'description',
    	'semester_id',
    ];

    public function semester(){//Un curso pertenece a un semestre
    	return $this->belongsTo(Semester::class);
    }

    public function posts(){//Un curso tiene muchos posts
    	return $this->hasMany(Post::class);
    }
}
