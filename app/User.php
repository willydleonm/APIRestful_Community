<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    const verified_user = '1';
    const not_verified_user = '0';
    const admin_user = '1';
    const regular_user = '0';


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'verified',//Si el usuario está verificado
        'verification_token',//Para verificar el correo electrónico del usuario
        'is_admin',//Para saber si es usuario administrador
        'semester_id',
    ];

    public function setNameAttribute($value){
        $this->attributes['first_name']=strtolower($value);
        $this->attributes['last_name']=strtolower($value);
        //$this->attributes['first_name','last_name']=strtolower($value);
    }

    public function getNameAttribute($value){
        return ucwords($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //Arreglo que se utiliza para ocultar información al momento de generar el archivo json
    protected $hidden = [
        'password', 
        'remember_token',//Cuando el usuario le da check para recordar sus datos al iniciar sesión
        'verification_token',
    ];

    public function isAdmin(){
        return $this->admin == User::admin_user;
    }

    public function isVerified(){
        return $this->verified == User::verified_user;
    }

    public static function generateToken(){
        return str_random(30);//Genera cadena de 30 caracteres de forma aleatoria
    }

    public function posts(){//Un usuario tiene muchos posts
        return $this->hasMany(Post::class);
    }

    public function comments(){//Un usuario tiene muchos comentarios
        return $this->hasMany(Comment::class);
    }

    public function semester(){//Un usuario pertenece a un semestre
        return $this->belongsTo(Semester::class);
    }

    public function favorites(){//Un usuario tiene muchos favoritos
        return $this->hasMany(Favorite::class);   
    }


}
