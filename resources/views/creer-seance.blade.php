

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Création d'une session</title>
    </head>
    <body>
        @if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif
        <h1>Creation de la séance</h1>
        <form method="POST" action="">
            @csrf

            <label for="niv">Niveau de la formation :</label><br>
            <input type="number" id="niv" name="niv" min="1" max="3" value="1"><br>

            {{--
            <label for="lieu">Aptitudes travaillées:</label><br>
            <ul>
                @foreach($aptitudes as $apt)
                    <li><input type="checkbox" value="{{$apt->APT_CODE}}" name="aptitude[]">{{$apt->APT_LIBELLE}}</input></li>
                @endforeach
            </ul>
                --}}
            <br>

            <label for="lieu">Lieu :</label><br>
            <select name="lieu" id="lieu">
                @foreach($lieux as $lieu)
                    <option value="{{$lieu->LI_ID}}">{{$lieu->LI_NOM}}</option>
                @endforeach
            </select> <br>

            <label for="date">Date :</label><br>
            <input type="date" id="date" name="date" required><br>

            <label for="beginHour">Heure de début :</label><br>
            <div><input type="number" id="beginHour" name="beginHour" required min="0" max="23" value="0">:
                <input type="number" id="beginMin" name="beginMin" required min="0" max="59" value="0"></div><br><br>


            <label for="endHour">Heure de fin :</label><br>
            <div><input type="number" id="endHour" name="endHour" required min="0" max="23" value="0">:
                <input type="number" id="endMin" name="endMin" required min="0" max="59" value="0"></div><br>

            <label for="initiateur">Initiateur : </label>
            <select name="initiateur" id="initiateur">
                
                @foreach($initiateurs as $init)
                    <option value="{{$init->UTI_ID}}">{{$init->UTI_NOM}} {{$init->UTI_PRENOM}}</option>
                @endforeach

            </select>

            <label for="eleve1">Eleve 1 : </label>
            <select name="eleve1" id="eleve1">
                
                @foreach($eleves as $eleve)
                    <option value="{{$eleve->UTI_ID}}">{{$eleve->UTI_NOM}} {{$eleve->UTI_PRENOM}}</option>
                @endforeach

            </select>

            <label for="eleve2">Eleve 2 : </label>
            <select name="eleve2" id="eleve2">
                <option value="null">Aucun</option>

                @foreach($eleves as $eleve)
                    <option value="{{$eleve->UTI_ID}}">{{$eleve->UTI_NOM}} {{$eleve->UTI_PRENOM}}</option>
                @endforeach

            </select>
            <br>
            <input type="submit" value="Créer la séance">
            
        </form> 
    </body>
</html>
