<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
    @include('header')
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                <span class="font-medium"> {{session('success')}} </span>
            </div>
        @endif

        @php
            use App\Http\Controllers\RoleController;
            use Illuminate\Support\Facades\Auth;

            $userid = session('user')->UTI_ID;

            $roleController = new RoleController();
            $role = $roleController->getRole(session('user'));
        @endphp
        <div class="flex flex-col min-h-screen bg-cover bg-center">

            <div class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
                <h2 class="text-xl font-semibold text-center mb-6">{{strtoupper($user->UTI_NOM) ." ". $user->UTI_PRENOM }}</h2>
                
                
                <!-- display user's informations -->
                <p>Email : {{$user->UTI_MAIL}}</p>
                <p>Mot de passe : *****</p>
                <div id="address">Adresse : {{$user->UTI_ADRESSE .", ". $user->UTI_CODE_POSTAL ." ". $user->UTI_VILLE}}</div>
                <p>Date de naissance : {{date("d/m/Y", strtotime($user->UTI_DATE_NAISSANCE))}}</p>
                <p>Date de votre certificat médical : {{date("d/m/Y", strtotime($user->UTI_DATE_CERTIFICAT))}}</p>
                <p>Niveau de plongée : {{$user->UTI_NIVEAU}}</p>

                @if($role != 'directeur_technique')
                    <button onclick="alertSuppAccount()" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Supprimer un compte</button>
                @endif
                </br>
                </br>
                @if($role != 'directeur_technique')
                    <a href="{{ route('changeData.showPassword') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Modifier le mot de passe
                    </a>
                    </br>
                    </br>
                    <a href="{{ route('changeData.showEmail') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Modifier l'adresse email
                    </a>
                
                @endif
            </div>

            @include('footer')
        </div>
        <script>
            function alertSuppAccount(){
                alert("Un message a bien été envoyé au directeur technique pour supprimer votre compte");
            }
        </script>
    </body>
</html>