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
    <div class="px-4 py-5 my-5 text-center" style="--bs-bg-opacity: .5; ">
        <h3>Créer un compte utilisateur</h3>
        <form method="POST" action="" style="margin-bottom: 10px;">
            @csrf
            <div class="form-group">
                <label for="uti_nom">Nom</label>
                <input type="text" id="uti_nom" name="uti_nom" value="" placeholder="Marie">
                @error("uti_nom")
                    {{$message}}
                @enderror
            </div>

            <div class="form-group">
                <label for="uti_prenom">Prénom</label>
                <input type="text" id="uti_prenom" name="uti_prenom" value="Gérard">
                @error("uti_prenom")
                    {{$message}}
                @enderror
            </div class="form-group">

            <div class="form-group">
                <label for="uti_mail">Email</label>
                <input type="text" id="uti_mail" name="uti_mail" value="gerard.marie@gmail.com">
                @error("uti_mail")
                    {{$message}}
                @enderror
            </div class="form-group">

            <div class="form-group">
                <label for="clu_id">Club</label>
                <select id="clu_id" name="clu_id">
                    @foreach ($clubs as $club)
                        <option value="{{ $club->clu_id }}">{{ $club->clu_nom }}</option>
                    @endforeach
                </select>

                @error("clu_id")
                    {{$message}}
                @enderror
            </div class="form-group">

            <div class="form-group">
                <label for="niveauUser">Niveau </label>
                <input id="niveauUser" type="text" name="uti_niveau" value="1">
                @error("uti_niveau")
                    {{$message}}
                @enderror
            </div>

            <div class="form-group">
                <label for="uti_date_naissance">Date de naissance</label>
                <input id="uti_date_naissance" type="date" name="uti_date_naissance" value="1970-01-01" min="1970-01-01" max="{{today()}}"/>
                @error("uti_date_naissance")
                    {{$message}}
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="radio" id="userType1" name="userType" value="eleve" />
                    <label for="userType1">Eleve</label>
                </div>

                <div id="initiateurBtnRadio" class="form-check">
                    <input type="radio" id="userType2" name="userType" value="initiateur" />
                    <label for="userType2">Initiateur</label>
                </div>
            </div>

            <button class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

        <script>
            var niveau = document.getElementById("niveauUser");
            var initiateur = document.getElementById("userType2");
            initiateur.disabled = true;

            niveau.addEventListener('input', function () {
                if(parseInt(niveau.value) < 2){
                    initiateur.disabled = true;
                }
                else{
                    initiateur.disabled = false;
                }
            });
        </script>
    </body>
</html>