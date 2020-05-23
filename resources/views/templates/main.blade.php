<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- <link type="text/css" rel="stylesheet" href="css/material-kit.min.css"  media="screen,projection"/> -->
        <!-- <link type="text/css" rel="stylesheet" href="css/material-kit.min.css"/> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <meta charset="utf-8">
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/sidebar.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/index.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/footer.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/header.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/contacto.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/more.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/habilities.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/informacion.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/projects.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/about.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/barra.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('css/svg.css') }}"/>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        {{-- <link href="{{ asset('css/ajuda.css') }}" rel="stylesheet"> --}}

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js"></script>
        <title>@yield('titulo')</title>
    </head>
    <body>
        @yield('body')

        <script src='{{ asset('js/jquery.fullpage.min.js') }}'></script>
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script src="{{ asset('js/ScrollMagic.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sidebar.js') }}" type="text/javascript"></script>

        {{-- PDF --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.4.3/jspdf.plugin.autotable.min.js"></script>

        <script>
            AOS.init();
        </script>
        <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
