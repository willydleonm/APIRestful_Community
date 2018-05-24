<?php

namespace App\Http\Controllers\Course;

use App\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CourseController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $courses_list = Course::all();
        return $this->showAll($courses_list);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'course_name' => 'required',
            'code' => 'required',
            'credits' => 'required',
            'required_course' => 'required',
            'required_credits' => 'required',
            'semester_id' => 'required'
        ];
        $this->validate($request, $rules);
        $course = Course::create($request->all());
        return $this->showOne($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return $this->showOne($course);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
         $course->fill($request->intersect([
            'course_name',
            'code',
            'credits',
            'description',
            'required_course',
            'required_credits',
            'semester_id',
         ]));

        if($course->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }
        $course->save();
        return $this->showOne($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return $this->showOne($course);
    }
}
