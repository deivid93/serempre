<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <div class="card col" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Usuario: <b>{{$user->name}}</b> </h5>
                <p>Su registro a sido exitoso</p>
                <br>
                <p>En el siguiente enlace podra establecer su contraseña:</p>
                <a class="btn btn-success" href="{{config('app.url')}}/password/reset/{{$token}}?email={{$user->email}}">Establecer Contraseña</a>
            </div>
        </div>
    </div>
</body>
</html>


