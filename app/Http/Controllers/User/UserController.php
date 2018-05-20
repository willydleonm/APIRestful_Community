<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_list = User::all();
        return response()->json(['data' => $users_list],200);
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
        return response()->json(['data'=>$user],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*  Mostrar un usuario correspondiente a un $id
            findOrFail => devuelve un error si no es encontrado el usuario Error 404
        */
        $user = User::findOrFail($id);
        return response()->json(['data' => $user],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
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
            if(!$user->isVerified()){
                return response()->json(['error'=>'Sólo los usuarios verificados pueden cambiar su valor de administrador','code'=>409],409);
            }
            $user->is_admin = $request->is_admin;
        }

        //Si no se modificaron datos
        if(!$user->isDirty()){
            return response()->json(['error'=>'Se debe especificar al menos un valor diferente para actualizar','code'=>422],422);
        }

        $user->save();
        return response()->json(['data' => $user],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
