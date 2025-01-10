<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aptitudes Table Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    @include('header')

    <div class="container mx-auto py-8 bg-[url('/img/scub1.png')] bg-cover bg-no-repeat bg-center h-screen">
        <h1 class="text-3xl font-bold mb-6 text-center"> Bilan des aptitudes de {{ $student->UTI_PRENOM }}
            {{ $student->UTI_NOM }}</h1>

        <!-- Centrer le tableau et ajouter un défilement horizontal -->
        <div class="max-w-7xl mx-auto bg-white p-4 shadow-md rounded-lg overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Date</th>
                        @foreach ($skillsList as $skill)
                            <th class="px-4 py-2 border border-gray-300" colspan="{{ $skill->TOTAL }}">
                                {{ $skill->CPT_ID }}</th>
                        @endforeach
                    </tr>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2 border border-gray-300"></th>
                        @foreach ($aptitudesList as $aptitude)
                            <th class="px-4 py-2 border border-gray-300">{{ $aptitude->APT_CODE }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessionsList as $session)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <th class="px-4 py-2 border border-gray-300 font-medium">{{ $session->SEA_DATE_DEB }}</th>
                            @foreach ($aptitudesList as $aptitude)
                                @php
                                    $found = false; // Drapeau pour savoir si un résultat existe
                                @endphp
                                @foreach ($evaluationsList as $evaluation)
                                    @if ($evaluation->SEA_ID === $session->SEA_ID && $evaluation->APT_CODE === $aptitude->APT_CODE)
                                        @if ($evaluation->EVA_RESULTAT === 'Acquis')
                                            <td
                                                class="px-4 py-2 border border-gray-300 bg-green-400 text-white text-center">
                                                {{ $evaluation->EVA_RESULTAT }}
                                            </td>
                                        @elseif($evaluation->EVA_RESULTAT === 'En cours')
                                            <td
                                                class="px-4 py-2 border border-gray-300 bg-orange-400 text-white text-center">
                                                {{ $evaluation->EVA_RESULTAT }}
                                            </td>
                                        @else
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                {{ $evaluation->EVA_RESULTAT }}
                                            </td>
                                        @endif
                                        @php
                                            $found = true; // Résultat trouvé
                                        @endphp
                                    @break
                                @endif
                            @endforeach

                            @if (!$found)
                                <td class="px-4 py-2 border border-gray-300 text-center"></td>
                                <!-- Case vide si aucun résultat -->
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('footer')
</body>

</html>
