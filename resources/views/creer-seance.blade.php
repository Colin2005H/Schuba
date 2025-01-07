

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Création d'une session</title>
    </head>
    <body>
        <h1>Creation de la séance</h1>

        

        <ul>
            @foreach($lieux as $lieu)
                <li>{{$lieu->LI_NOM}}</li>
            @endforeach
        </ul>
    </body>
</html>
