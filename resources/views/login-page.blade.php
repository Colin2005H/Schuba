<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Schuba</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col min-h-screen bg-cover bg-center bg-[url('/img/scub1.png')]">
        <div class="text-center bg-white self-center w-full justify-items-center drop-shadow-lg">
            <img src="{{ asset('img/logo1.svg') }}" alt="Logo" class="h-20">
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
            <h2 class="font-bold text-[#004B85] text-center text-2xl m-4 mb-10">Connexion</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="flex w-full">

                        <img src="{{ asset('img/Diver.png') }}" alt="diver" class="mr-3">
                        <label class="flex items-center gap-2 text-gray-700 w-full">
                            <input type="text" name="uti_mail" value="{{ old('uti_mail') }}"
                                placeholder="Nom d'utilisateur"
                                class="w-full flex-grow px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </label>

                    </div>
                    @error('uti_mail')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">

                    <div class="flex w-full">

                        <img src="{{ asset('img/Lock.png') }}" alt="diver" class="mr-3">
                        <label class="flex items-center gap-2 text-gray-700 w-full">
                            <input type="password" name="password" placeholder="Mot de passe"
                                class="w-full flex-grow px-3 py-2 bg-white border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </label>

                    </div>

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
                    <button type="submit"
                        class="flex items-center justify-center text-white hover:bg-blue-500 p-4 rounded-md mt-10"
                        style="background-color: rgba(23, 34, 49, 1);">
                        <p>Se connecter</p>
                    </button>
                </div>
            </form>
        </div>


    </div>
    @include('footer')

</body>

</html>
