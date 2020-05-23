<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestió de Trucades d'Assistència</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('css/register.css') }}"/>
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
                        <h5 class="card-title boxTitle">REGISTRA'T</h5>

                        <div class="card-body ml-5 mr-5">
                            <form action="{{ action('Auth\RegisterController@create') }}" method="post">
                                @csrf

                                <div class="form-group row">
                                    {{-- Nom --}}
                                    <div class="form-group col-md-5">
                                        <label for="nom" class="col-form-label">Usuari</label>
                                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Introdueix l'usuari" aria-describedby="helpId" value="{{ old('nom') }}" autofocus>
                                    </div>

                                    {{-- Codi --}}
                                    <div class="form-group col-md-5 ml-5">
                                        <label for="codi" class="col-form-label">Codi</label>
                                        <input type="text" name="codi" id="codi" class="form-control" placeholder="Introdueix el codi" aria-describedby="helpId" value="{{ old('codi') }}" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{-- Contrasenya --}}
                                    <div class="form-group col-md-5">
                                        <label for="contrasenya" class="col-form-label">Contrasenya</label>
                                        <input type="password" name="contrasenya" id="contrasenya" class="form-control" placeholder="Introdueix la contrasenya" aria-describedby="helpId" value="{{ old('contrasenya') }}">
                                    </div>

                                    {{-- Rols --}}
                                    <div class="form-group col-md-5 ml-5">
                                        <label for="cbRol" class="col-form-label">Rol</label><br>
                                        <select class="form-control" id="cbRol" name="cbRol" type="text">
                                            <option disabled selected> -- Escull una opció -- </option>
                                            @foreach ($rols as $rol)
                                                @if ($rol->nom != 'Admin')
                                                    <option value="{{ $rol->id }}">{{ $rol->nom }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Botones --}}
                                <div class="form-group row">
                                    <div class="col-md-auto mt-3">
                                        <button type="submit" class="btn btnAceptar">ACEPTAR</button>
                                        <a name="" id="" class="btn btnCancelar" href="{{ url('/login') }}" role="button">Cancel·lar</a>
                                    </div>
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
