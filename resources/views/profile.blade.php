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
    <div class="flex flex-col min-h-screen bg-[url('img/underwater.png')] bg-cover bg-center ">

        <div
            class="bg-[rgb(255,255,255,0.8)] p-6 rounded-lg shadow-md sm:w-96 items-center justify-center mx-auto my-auto">
            <h2 class="text-xl font-semibold text-center mb-6">{{ strtoupper($user->UTI_NOM) . ' ' . $user->UTI_PRENOM }}
            </h2>

            <div>
                <p>Email : {{ $user->UTI_MAIL }}</p>
                <p>Mot de passe : *****</p>

                <div class="text-center my-4">
                    <button
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 min-w-52"
                        disabled>Modifier le mot de passe</button>
                    <button
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 min-w-52"
                        disabled>Modifier l'adresse email</button>
                </div>
            </div>

            <!-- display user's informations -->
            <div>
                <div id="address">Adresse :
                    {{ $user->UTI_ADRESSE . ', ' . $user->UTI_CODE_POSTAL . ' ' . $user->UTI_VILLE }}</div>
                <p>Date de naissance : {{ date('d/m/Y', strtotime($user->UTI_DATE_NAISSANCE)) }}</p>
                <p>Date de votre certificat médical : {{ date('d/m/Y', strtotime($user->UTI_DATE_CERTIFICAT)) }}</p>
                <p>Niveau de plongée : {{ $user->UTI_NIVEAU }}</p>
            </div>

            <div class="text-center my-4">
                <button
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 min-w-52"
                    disabled>Supprimer un compte</button>
            </div>

        </div>
    </div>
    @include('footer')
</body>

</html>
