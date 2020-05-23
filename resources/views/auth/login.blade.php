<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestió de Trucades d'Assistència</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('css/login.css') }}"/>
    </head>
    <body>

        <header>
            <div class="boxHeader">
                <img src="{{ asset('storage/media/img/broggi_cep.svg') }}" class="logoCepBroggi" alt="Logotip del Broggi i el logotip del CEP">
                <div class="titleGTA">
                    Gestió de Trucades d'Assistència
                </div>
            </div>
        </header>

        <div class="container">

            @include('partial.errores')

            <div class="card mt-5 mr-auto ml-auto">

                <div class="row no-gutters">
                    <div class="col-md-4 align-items-center justify-content-center">
                        <img src="{{ asset('storage/media/img/logo.svg') }}" class="card-img logo" alt="Logotip de l'aplicació">
                    </div>
                    <div class="col-md-8">
                        <h5 class="card-title boxTitle">LOGIN</h5>

                        <div class="card-body ml-5 mr-5">
                            <form action="{{ action('Auth\LoginController@login') }}" method="post">
                                @csrf

                                {{-- Nom --}}
                                <div class="form-group">
                                    <label for="nom" class="col-form-label">Usuari</label>
                                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Introdueix l'usuari" aria-describedby="helpId" value="{{ old('nom') }}" autofocus>
                                </div>

                                {{-- Contrasenya --}}
                                <div class="form-group">
                                    <label for="contrasenya" class="col-form-label">Contrasenya</label>
                                    <input type="password" name="contrasenya" id="contrasenya" class="form-control" placeholder="Introdueix la contrasenya" aria-describedby="helpId" value="{{ old('contrasenya') }}">
                                </div>

                                {{-- Botones --}}
                                <div class="form-group row">
                                    <div class="col-md-auto mt-3">
                                        <button type="submit" class="btn btnAceptar">ACEPTAR</button>
                                        {{-- <a name="" id="" class="btn btn-secondary" href="{{ url('/login') }}" role="button">CANCELAR</a> --}}
                                    </div>
                                    {{-- <div class="col-md-auto ml-auto mt-3">
                                        <a name="" id="" class="btn btnRegistrar" href="{{ url('/register') }}" role="button">Registra't</a>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
