<?php

namespace App\Http\Controllers\Favorite;

use App\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class FavoriteController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites_list = Favorite::all();
        return $this->showAll($favorites_list);
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
            'user_id' => 'required',
            'post_id' => 'required'
        ];  
        $this->validate($request, $rules);
        $favorite = Favorite::create($request->all());
        return $this->showOne($favorite);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        return $this->showOne($favorite);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return $this->showOne($favorite);
    }
}
