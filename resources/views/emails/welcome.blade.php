Hola {{$user->username}}
Gracias por crear tu cuenta. Por favor verifícala utilizando el siguiente enlace:

{{route('verify',$user->verification_token)}}