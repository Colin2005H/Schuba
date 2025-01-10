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

            <form method="POST" action="" style="margin-bottom: 10px;">
                @csrf
                <div class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
                    <div>
                        <div class="mb-4">
                            <label class="flex items-center gap-2 text-gray-700">
                                Ancienne adresse email
                                <input type="text" id="uti_mail" name="uti_mail" value="{{ $info_compte[0]->UTI_MAIL }}" placeholder="Adresse email" class="w-full px-3 py-2 bg-gray-300 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
                            </label>
                            <label class="flex items-center gap-2 text-gray-700">
                                Nouvelle adresse email
                                <input type="text" id="uti_new_mail" name="uti_new_mail" value="{{ $info_compte[0]->UTI_MAIL }}" placeholder="Adresse email" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </label>
                            @error("uti_new_mail")
                                <span class="text-red-500 text-sm">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <input type="submit" name="editEmail" value="Confirmer" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    </div>
                </div>
            </form>

            <form method="POST" action="" style="margin-bottom: 10px;">
                @csrf
                <div class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
                    <div>
                        <div class="mb-4">
                            <label class="flex items-center gap-2 text-gray-700">
                                Entrez l'ancien mot de passe
                                <input type="password" id="uti_mdp" name="uti_mdp" value="" placeholder="Mot de passe" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </label>
                            <label class="flex items-center gap-2 text-gray-700">
                                Entrez le nouveau mot de passe
                                <input type="password" id="uti_new_mdp" name="uti_new_mdp" value="" placeholder="Nouveau mot de passe" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </label>
                            @error("uti_mdp")
                                <span class="text-red-500 text-sm">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <input type="submit" name="editPassword" value="Confirmer" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    </div>
                </div>
            </form>

            <footer class="mt-auto text-center text-white text-sm py-4 w-full" style="background-color: rgba(23, 34, 49, 1);">
                <p>Nous contacter</p>
                <p>+33 2 34 56 78 91</p>
                <p>contact@schuba.fr</p>
                <p>&copy; Groupe1</p>
            </footer>
        </div>
    </body>
</html>