<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    public function courses(){//Un semestre tiene muchos cursos
    	return $this->hasMany(Course::class);
    }
}
