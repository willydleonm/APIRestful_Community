<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable =[
    	'course_name',
        'code',
        'credits',
    	'description',
        'required_course',
        'required_credits',
    	'semester_id',
    ];

    public function semester(){//Un curso pertenece a un semestre
    	return $this->belongsTo(Semester::class);
    }

    public function posts(){//Un curso tiene muchos posts
    	return $this->hasMany(Post::class);
    }
}
