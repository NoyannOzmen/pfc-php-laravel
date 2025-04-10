<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Pet Foster Connect, mise en relations entre refuges de protection animale et familles d'accueil">
        <title>{{ config('app.name', 'Pet Foster Connect') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('/icons/favicon.ico') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Grandstander:ital,wght@0,100..900;1,100..900&display=swap');
        </style>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0');
        </style>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Grandstander:ital,wght@0,100..900;1,100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap');
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('scripts')
        <script src="{{ asset('js/menuBurger.js') }}" defer></script>

    </head>
    <body class="w-screen h-screen font-body flex flex-col bg-fond">
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
    </body>

</html>
