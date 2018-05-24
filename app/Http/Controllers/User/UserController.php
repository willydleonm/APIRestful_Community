<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_list = User::all();
        return $this->showAll($users_list);
    }

    /**
     * Store a newly created resource in storage.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Reglas de validación
            required = campo requerido
            unique = campo único
            min:6 = caracteres mínimos para la password
            confirmed = el campo debe escribirse dos veces para ser confirmado
        */
        $rules = [
            'username' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:6|confirmed',
            'semester_id' => 'required'
        ];

        $this->validate($request, $rules);

        //Campos de la request
        $fields = $request->all();
        $fields['password'] = bcrypt($request->password);
        $fields['verified'] = User::not_verified_user;
        $fields['verification_token'] = User::generateToken();
        $fields['is_admin'] = User::regular_user;
        //Asignación masiva
        $user = User::create($fields);
        //Retorno de respuesta tipo 201 que ya se realizó la operación
        return $this->showOne($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
         $rules = [
            'password' => 'min:6|confirmed',
            'is_admin' => 'in' . User::admin_user . ',' . User::regular_user
        ];

        $this->validate($request, $rules);

        //Si se ingresa campo password y es diferente al que está en la tabla se modifica
        if($request->has('password') && (Hash::check($request->password, $user->password)==false)){
            $user->password = bcrypt($request->password);
        }

        if($request->has('first_name') && ($user->first_name != $request->first_name)){
            $user->first_name = $request->first_name;
        }

        if($request->has('last_name')&& ($user->last_name != $request->last_name)){
            $user->last_name = $request->last_name;
        }

        if($request->has('is_admin')){
            if($user->isVerified()==false){
                return $this->errorResponse('Sólo los usuarios verificados pueden cambiar su valor de administrador',409);
            }
            $user->is_admin = $request->is_admin;
        }

        //Si no se modificaron datos
        if($user->isClean()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }

        $user->save();
        return $this->showOne($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }
}
