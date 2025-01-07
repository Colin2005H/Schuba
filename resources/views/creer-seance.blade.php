

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Création d'une session</title>
    </head>
    <body>
        <h1>Creation de la séance</h1>
        <form>

            <label for="niv">Niveau de la formation :</label><br>
            <input type="text" id="niv" name="niv"><br>

            <label for="lieu">Lieu:</label><br>
            <input type="text" id="lieu" name="lieu"><br>

            <label for="dateD">Date de début :</label><br>
            <input type="text" id="dateD" name="dateD"><br>

            <label for="dateF">Date de fin :</label><br>
            <input type="text" id="dateF" name="dateF"><br><br>

            <input type="submit" value="Créer la séance">
            
        </form> 

        

        <ul>
            @foreach($lieux as $lieu)
                <li>{{$lieu->LI_NOM}}</li>
            @endforeach
        </ul>
    </body>
</html>
