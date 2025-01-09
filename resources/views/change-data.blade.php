<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modification</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        @include('header')

        @if(session('failure'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                <span class="font-medium"> {{session('failure')}} </span>
            </div>
        @endif

        <p id="changeDataValue" class="hidden">{{$changeDataValue}}</p>

        <div id="editEmail" class="">
            <form method="POST" action="" style="margin-bottom: 10px;">
                @csrf
                
                <label for="uti_old_mail">Ancienne adresse email</label>
                <input type="text" id="uti_old_mail" name="uti_old_mail" value="{{ $user->UTI_MAIL }}" placeholder="Adresse email" readonly>
                            
                <label for="uti_mail"> Nouvelle adresse email</label>
                <input type="text" id="uti_mail" name="uti_mail" value="{{ $user->UTI_MAIL }}" placeholder="Adresse email">
                
                @error("uti_mail")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
                        
                <button>Confirmer</button>
            </form>
        </div>

        <div id="editPassword" class="">
            <form method="POST" action="" style="margin-bottom: 10px;">
                @csrf
                
                <label for="uti_old_mdp">Entrez l'ancien mot de passe</label>
                <input type="password" id="uti_old_mdp" name="uti_old_mdp" value="" placeholder="Ancien mot de passe">

                @error("uti_old_mdp")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
                            
                <label for="uti_mdp">Entrez le nouveau mot de passe</label>
                <input type="password" id="uti_mdp" name="uti_mdp" value="" placeholder="Nouveau mot de passe">

                @error("uti_mdp")
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
                        
                <button>Confirmer</button>
            </form>
        </div>
    </body>
    <script>
        var pageValue = document.getElementById('changeDataValue');
        if(pageValue.textContent == "email"){
            document.getElementById('editEmail').classList.remove('hidden');
            document.getElementById('editPassword').classList.add('hidden');
        }
        if(pageValue.textContent == "password"){
            document.getElementById('editPassword').classList.remove('hidden');
            document.getElementById('editEmail').classList.add('hidden');
        }
    </script>
</html>