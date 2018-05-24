<?php

namespace App\Http\Controllers\Comment;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $comments_list = Comment::all();
        return $this->showAll($comments_list);
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
            'content' => 'required|min:1',
            'date'=> 'required',
            'post_id' => 'required',
            'user_id'=> 'required',
        ];
        $this->validate($request, $rules);
        $comment = Comment::create($request->all());
        return $this->showOne($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return $this->showOne($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->fill($request->intersect([
            'content',
        ]));
        //Si no se modificaron datos
        if($comment->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $comment->save();
        return $this->showOne($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->showOne($comment);
    }
}
