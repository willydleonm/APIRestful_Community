<?php

namespace App\Http\Controllers\Photo;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class PhotoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos_list = Photo::all();
        return $this->showAll($photos_list);
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
            'url_photo' => 'image',
            'post_id' => 'required'
        ];   
        $this->validate($request, $rules);
        $data = $request->all();
        $data['url_photo'] = $request->photo->store('');
        $photo = Photo::create($data);
        return $this->showOne($photo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return $this->showOne($photo);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        if($request->has('url_photo') && $photo->url_photo != $request->url_photo){
            $photo->url_photo = $request->url_photo;
        }

        if($request->hasFile('url_photo')){
            Storage::delete($photo->url_photo);
            $photo->url_photo = $request->url_photo->store('');
        }

        if($photo->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }
        $photo->save();
        return $this->showOne($photo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        Storage::delete($photo->url_photo);
        $photo->delete();
        return $this->showOne($photo);
    }
}
