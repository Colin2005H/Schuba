<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCHUBA - Le hub des écoles de plongée</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

    @include('header')

    <div class="container w-full place-content-center place-self-center">
        <!-- Image de fond -->
        <div class="relative bg-cover bg-center h-96 w-full "
            style="background-image: url({{ asset('img/scub1.png') }});">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <h1 class="text-white text-4xl font-bold text-center">SCHUBA : le hub des écoles de plongée</h1>

            </div>
        </div>

        <!-- Section de contenu -->

        <div class="flex py-10 px-4 justify-center">
            <div class="self-center">
                <p class="text-lg leading-7 text-justify max-w-3xl mr-20">
                    Bienvenue sur SCHUBA, notre site dédié à la passion de la plongée sous-marine. Réservé à nos
                    membres, ce site permet de consulter votre emploi du temps de séances et vos progrès en toute
                    simplicité. Plongez dans un univers sur mesure, adapté à vos besoins et à vos objectifs!
                </p>
            </div>
            <div class="justify-center">
                <!-- Image du plongeur -->
                <img src="{{ asset('img/scub2.png') }}" alt="Plongeur" class="rounded-lg shadow-md w-64 h-auto">
            </div>
        </div>
    </div>
    @include('footer')

</body>

</html>
