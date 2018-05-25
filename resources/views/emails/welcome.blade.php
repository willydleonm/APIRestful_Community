@component('mail::message')
# Hola {{$user->username}}
Gracias por crear tu cuenta. Por favor verifícala!
@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirmar cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
