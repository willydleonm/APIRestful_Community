<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            'birth_date' => 'required',
            'email' => 'required|email|unique:users',
            'photo' => 'image',
            'semester_id' => 'required'
        ];

        $this->validate($request, $rules);

        //Campos de la request
        $fields = $request->all();
        $fields['password'] = bcrypt($request->password);
        $fields['photo'] = $request->photo->store('');
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
            'password' => 'required|confirmed',
            'email' => 'email|unique:users,email,' . $user->id,
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

        if($request->has('email')&&($user->email != $request->email)){
                $user->verified = User::not_verified_user;
                $user->verification_token = User::generateToken();
                $user->email = $request->email;
        }

        if($request->has('birth_date')&&($user->birth_date != $request->birth_date)){
            $$user->birth_date = $request->birth_date;
        }

        if($request->hasFile('photo')){
            Storage::delete($user->photo);
            $user->photo = $request->photo->store('');
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

    public function verify($token){
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::verified_user;
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }

    public function resend(User $user){
        if($user->isVerified()){
            return $this->errorResponse('Este usuario ya ha sido verificado',409);
        }

        retry(5, function() use ($user){
            Mail::to($user)->send(new UserCreated($user));
        },100);

        return $this->showMessage('El correo de verificación se ha reenviado');
        
    }
}
