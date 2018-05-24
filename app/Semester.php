<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $fillable = [
        'semester',
    ];
    
	public function courses(){//Un semestre tiene muchos cursos
    	return $this->hasMany(Course::class);
    }
}
