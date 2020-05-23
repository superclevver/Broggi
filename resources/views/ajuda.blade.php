<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestió de Trucades d'Assistència</title>
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ajuda.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <ajuda></ajuda>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
