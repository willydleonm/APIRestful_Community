<?php

namespace App\Http\Controllers\Semester;

use App\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SemesterController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters_list = Semester::all();
        return $this->showAll($semesters_list);
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
            'semester' => 'required',
        ];
        $this->validate($request, $rules);
        $semester = Semester::create($request->all());
        return $this->showOne($semester,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        return $this->showOne($semester);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        $semester->fill($request->intersect([
            'semester',
        ]));

        if($semester->isClean()){
            return response()->json(['error'=>'Se debe especificar al menos un valor diferente para actualizar','code'=>422],422);
        }

        $semester->save();
        return $this->showOne($semester);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();
        return $this->showOne($semester);
    }
}
