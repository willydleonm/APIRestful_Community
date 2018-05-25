@component('mail::message')
# Hola {{$user->username}}
Has cambiado tu correo electrónico. Por favor verifícalo!
@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirmar cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent