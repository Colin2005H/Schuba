<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir le niveau</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    @include('header')
    <div class="bg-[url('/img/underwater.png')] h-full bg-cover bg-no-repeat bg-center p-10">
        <div class="flex flex-col min-h-screen items-center justify-center">
            <h1 class="text-3xl text-white font-semibold mb-8">Quel niveau voulez-vous ?</h1>

            <a href="{{ url('/globalAptitudes/' . '1') }}"
                class="text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-3 mb-4">
                Le Niveau 1
            </a>

            <a href="{{ url('/globalAptitudes/' . '2') }}"
                class="text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-3 mb-4">
                Le Niveau 2
            </a>

            <a href="{{ url('/globalAptitudes/' . '3') }}"
                class="text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-3 mb-4">
                Le Niveau 3
            </a>
        </div>
    </div>
    @include('footer')
</body>
