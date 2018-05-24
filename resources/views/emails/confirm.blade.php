Hola {{$user->username}}
Has cambiado tu correo electrónico. Por favor verifícalo utilizando el siguiente enlace:

{{route('verify',$user->verification_token)}}