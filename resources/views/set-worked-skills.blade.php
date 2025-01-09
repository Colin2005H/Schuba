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

        <h1>Selection des aptitudes travaillées</h1>

        
        
        
        <form action="" method="POST">
            @csrf

            <!--TODO mettre en forme le formulaire : regrouper les aptitudes par compétences par exemple-->
            @foreach ($eleves as $eleve)
            <div>
                <!--TODO on pourrais rajouter un lien pour voir le profil de l'élève-->
                <h3>{{$eleve->UTI_PRENOM}} {{$eleve->UTI_NOM}}</h3>

                @foreach($aptitudes as $apt)
                <span>
                    <label for="{{$apt->APT_CODE}}">{{$apt->APT_LIBELLE}}</label>
                    <input type="checkbox" name="apt[{{$eleve->UTI_ID}}][]" id="{{$apt->APT_CODE}}" value="{{$apt->APT_CODE}}">
                </span>
                @endforeach
            </div>
                

            @endforeach

            <div>
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Valider</button>
            </div>
            
        </form>
    </body>
</html>
