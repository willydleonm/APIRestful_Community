<?php

namespace App\Providers;

use App\User;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Todas las cadenas tendrán un mínimo de 191 caracteres
        //para resolver problema de compatiblidad de mysql
        Schema::defaultStringLength(191);

        User::created(function($user){
            //5 intentos para enviar el email si existe un problema 
            retry(5, function() use ($user){
                Mail::to($user)->send(new UserCreated($user));
            },100);
        });

        User::updated(function($user){
            if($user->isDirty('email')){
               retry(5, function() use ($user){
                    Mail::to($user)->send(new UserMailChanged($user));
               },100); 
            }
            
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
