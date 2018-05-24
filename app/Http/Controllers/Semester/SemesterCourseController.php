<?php

namespace App\Http\Controllers\Semester;

use App\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SemesterCourseController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Semester $semester)
    {
        $courses = $semester->courses;
        return $this->showAll($courses);
    }
    
}
