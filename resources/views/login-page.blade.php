<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Schuba</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex flex-col min-h-screen bg-cover bg-center">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-black flex items-center justify-center gap-2 py-2">
                SCHUBA
            </h1>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
            <h2 class="text-xl font-semibold text-center mb-6">Connexion</h2>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="flex items-center gap-2 text-gray-700">
                        <input type="text" name="uti_mail" value="{{ old('uti_mail') }}" placeholder="Nom d'utilisateur" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </label>
                    @error('uti_mail')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2 text-gray-700">
                        <input type="password" name="password" placeholder="Mot de passe" class="w-full px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </label>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @error('uti_mail')
                    <div class="text-red-500 text-sm mb-2">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror

                <div class="flex justify-center">
                    <button type="submit" class="flex items-center justify-center text-white hover:bg-blue-500 p-4 rounded-md" style="background-color: rgba(23, 34, 49, 1);">
                        <p>Se connecter</p>
                    </button>
                </div>
            </form>
        </div>

        <footer class="mt-auto text-center text-white text-sm py-4 w-full" style="background-color: rgba(23, 34, 49, 1);">
            <p>Nous contacter</p>
            <p>+33 2 34 56 78 91</p>
            <p>contact@schuba.fr</p>
            <p>&copy; Groupe1</p>
        </footer>
    </div>

</body>
</html>
