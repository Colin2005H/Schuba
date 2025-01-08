<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Création d'une session</title>
        <script defer src="{{ asset('js/createSession.js') }}"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 text-gray-900 font-sans">
        @include('header')

        <h1>CA MARCHE</h1>

        <form action="">
            @foreach ($eleves as $eleve)
                <h3>{{$eleve->UTI_PRENOM}} {{$eleve->UTI_NOM}}</h3>

                

            @endforeach
        </form>
        
    </body>
</html>
