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

        <!-- failure alert if the user make a mistake in his old password-->
        @if(session('failure'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                <span class="font-medium"> {{session('failure')}} </span>
            </div>
        @endif

        <!-- help to reveal the selected form -->
        <p id="changeDataValue" class="hidden">{{$changeDataValue}}</p>

        <!-- display form to edit the email -->
        <div id="editEmail" class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
            <form method="POST" action="" style="margin-bottom: 10px;">
                @csrf
                <div class="mb-4">
                    <label for="uti_old_mail">Ancienne adresse email</label>
                    <input type="text" id="uti_old_mail" name="uti_old_mail" value="{{ $user->UTI_MAIL }}" placeholder="Adresse email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly>
                </div>
                           
                <div class="mb-4">
                    <label for="uti_mail"> Nouvelle adresse email</label>
                    <input type="text" id="uti_mail" name="uti_mail" value="{{ $user->UTI_MAIL }}" placeholder="Adresse email" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                
                    @error("uti_mail")
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
                        
                <button class="flex items-center justify-center text-white bg-blue-500 p-4 rounded-md mx-auto my-auto">Confirmer</button>
            </form>
        </div>

        <!-- display form to edit the email -->
        <div id="editPassword" class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
            <form method="POST" action="" style="margin-bottom: 10px;">
                @csrf
                
                <div class="mb-4">
                    <label for="uti_old_mdp">Entrez l'ancien mot de passe</label>
                    <input type="password" id="uti_old_mdp" name="uti_old_mdp" value="" placeholder="Ancien mot de passe" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

                    @error("uti_old_mdp")
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
                      
                <div class="mb-4">
                    <label for="uti_mdp">Entrez le nouveau mot de passe</label>
                    <input type="password" id="uti_mdp" name="uti_mdp" value="" placeholder="Nouveau mot de passe" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

                    @error("uti_mdp")
                        <span class="text-red-500 text-sm">{{$message}}</span>
                    @enderror
                </div>
                        
                <button class="flex items-center justify-center text-white bg-blue-500 p-4 rounded-md mx-auto my-auto">Confirmer</button>
            </form>
        </div>
        @include('footer')
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
    </body>
</html>