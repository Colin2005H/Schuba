<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Création d'une session</title>
    <script defer src="{{ asset('js/createSession.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 font-sans" onload="onPageLoaded()">
    @include('header')

    @if (session('success'))
        <div class="bg-green-100 text-green-800 border border-green-400 rounded p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-10 px-6 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Création de la séance</h1>

        <form method="POST" action="">
            @csrf


            <div class="mb-6 p-4 bg-gray-50 rounded-md shadow-md">
                <h2 class="font-semibold text-lg mb-4">1. Niveau de la formation</h2>
                <div class="mb-4">
                    <label for="niv" class="block font-medium text-gray-700">Niveau de la formation :</label>
                    <input type="number" id="niv" name="niv" min="1" max="3"
                        value="{{ $niveau }}"
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        readonly>
                </div>
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded-md shadow-md">
                <h2 class="font-semibold text-lg mb-4">2. Lieu de la séance</h2>
                <div class="mb-4">
                    <label for="lieu" class="block font-medium text-gray-700">Lieu :</label>
                    <select name="lieu" id="lieu"
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($lieux as $lieu)
                            <option value="{{ $lieu->LI_ID }}">{{ $lieu->LI_NOM }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="mb-6 p-4 bg-gray-50 rounded-md shadow-md">
                <h2 class="font-semibold text-lg mb-4">3. Date de la séance</h2>
                <div class="mb-4">
                    <label for="date" class="block font-medium text-gray-700">Date :</label>
                    <input type="date" id="date" name="date" required
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>


            <div class="mb-6 p-4 bg-gray-50 rounded-md shadow-md">
                <h2 class="font-semibold text-lg mb-4">4. Heure de début</h2>
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Heure de début :</label>
                    <div class="flex space-x-2 mt-2">
                        <input type="number" id="beginHour" name="beginHour" required min="0" max="23"
                            value="0"
                            class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span>:</span>
                        <input type="number" id="beginMin" name="beginMin" required min="0" max="59"
                            value="0"
                            class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>


            <div class="mb-6 p-4 bg-gray-50 rounded-md shadow-md">
                <h2 class="font-semibold text-lg mb-4">5. Heure de fin</h2>
                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Heure de fin :</label>
                    <div class="flex space-x-2 mt-2">
                        <input type="number" id="endHour" name="endHour" required min="0" max="23"
                            value="0"
                            class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span>:</span>
                        <input type="number" id="endMin" name="endMin" required min="0" max="59"
                            value="0"
                            class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>


            <div id="groupGlobalContainer" class="mb-6 p-4 bg-gray-50 rounded-md shadow-md">
                <h2 class="font-semibold text-lg mb-4">6. Groupes</h2>
                <div id="groupContainer1" class="mb-4 border p-4 rounded-md bg-gray-100">
                    <div class="mb-4">
                        <label for="initiateur1" class="block font-medium text-gray-700">Initiateur :</label>
                        <select name="group[1][initiateur]" id="initiateur1"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="onInitiatorSelect(1)">
                            @foreach ($initiateurs as $init)
                                <option value="{{ $init->UTI_ID }}">{{ $init->UTI_NOM }} {{ $init->UTI_PRENOM }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="eleve1_1" class="block font-medium text-gray-700">Élève 1 :</label>
                        <select name="group[1][eleve1]" id="eleve1_1" required
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="onStudentSelect(1, 1)">
                            @foreach ($eleves as $eleve)
                                <option value="{{ $eleve->UTI_ID }}">{{ $eleve->UTI_NOM }} {{ $eleve->UTI_PRENOM }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="eleve2_1" class="block font-medium text-gray-700">Élève 2 :</label>
                        <select name="group[1][eleve2]" id="eleve2_1"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="onStudentSelect(1, 2)">
                            <option value="null">Aucun</option>
                            @foreach ($eleves as $eleve)
                                <option value="{{ $eleve->UTI_ID }}">{{ $eleve->UTI_NOM }} {{ $eleve->UTI_PRENOM }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


            <div class="flex space-x-2 mb-6">
                <button type="button" id="plus" onclick="addGroupInput()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">+</button>
                <button type="button" id="minus" onclick="removeGroupInput()"
                    class="px-4 py-2 bg-red-500 text-white rounded-md shadow hover:bg-red-600">-</button>
            </div>


            <div>
                <input type="submit" value="Créer la séance"
                    class="w-full bg-black text-white py-2 rounded-md shadow hover:bg-gray-800">
            </div>

        </form>
    </div>
    @include('footer')
</body>

</html>
