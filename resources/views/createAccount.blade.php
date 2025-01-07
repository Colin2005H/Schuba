<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <h3>Créer un compte utilisateur</h3>
        <form method="POST" action="">
            @csrf
            <div>
                <label for="uti_nom">Nom</label>
                <input type="text" name="uti_nom" value="">
                @error("uti_nom")
                    {{$message}}
                @enderror
            </div>

            <div>
                <label for="uti_prenom">Prénom</label>
                <input type="text" name="uti_prenom" value="">
                @error("uti_prenom")
                    {{$message}}
                @enderror
            </div>

            <div>
                <label for="uti_mail">Email</label>
                <input type="text" name="uti_mail" value="">
                @error("uti_mail")
                    {{$message}}
                @enderror
            </div>

            <div>
                <label for="clu_id">Club</label>
                <select name="clu_id">
                    @foreach ($clubs as $club)
                        <option value="{{ $club->clu_id }}">{{ $club->clu_nom }}</option>
                    @endforeach
                </select>

                @error("clu_id")
                    {{$message}}
                @enderror
            </div>

            <div>
                <label for="uti_niveau">Niveau </label>
                <input type="text" name="uti_niveau" value="">
                @error("uti_niveau")
                    {{$message}}
                @enderror
            </div>

            <div>
                <label for="uti_date_naissance">Date de naissance</label>
                <input type="date" name="uti_date_naissance" value="1970-01-01" min="1970-01-01" max="{{today()}}"/>
                @error("uti_date_naissance")
                    {{$message}}
                @enderror
            </div>

            <button class="btn btn-primary">Enregistrer</button>
        </form>
</body>
</html>