<?php

namespace App\Http\Controllers\Profile;

use App\User;
use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;

class ProfileController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles_list = Profile::all();
        return $this->showAll($profiles_list);
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
            'birth_date' => 'required',
            'email' => 'required|email|unique:profiles',
            'photo' => 'image'
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $data['photo'] = $request->photo->store('');
        $profile = Profile::create($data);
        return $this->showOne($profile);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return $this->showOne($profile);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $user = User::findOrFail($profile->user_id);
        $rules = [
            'email' => 'email|unique:profiles,email,' . $user->id,
        ];

        $this->validate($request, $rules);
        if($request->has('email')&&($profile->email != $request->email)){
                $user->verified = User::not_verified_user;
                $user->verification_token = User::generateToken();
                $profile->email = $request->email;

        }

        if($request->has('birth_date')&&($profile->birth_date != $request->birth_date)){
            $profile->birth_date = $request->birth_date;
        }

        if($request->hasFile('photo')){
            Storage::delete($profile->photo);
            $profile->photo = $request->photo->store('');
        }

        if($user->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $profile->save();
        return $this->showOne($profile);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        Storage::delete($profile->photo);
        $profile->delete();
        return $this->showOne($profile);
    }
}
