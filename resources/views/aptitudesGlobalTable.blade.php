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
    
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center"> Bilan des aptitudes de la formation N{{$level}}</h1>

        <!-- Centrer le tableau et ajouter un défilement horizontal -->
        <div class="max-w-7xl mx-auto bg-white p-4 shadow-md rounded-lg overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Élève</th>
                        @foreach($skillsList as $skill)
                            <th class="px-4 py-2 border border-gray-300" colspan="{{$skill->TOTAL}}">{{ $skill->CPT_ID }}</th>
                        @endforeach
                    </tr>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-2 border border-gray-300"></th>
                        @foreach($aptitudesList as $aptitude)
                            <th class="px-4 py-2 border border-gray-300">{{ $aptitude->APT_CODE }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentsList as $student)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <th class="px-4 py-2 border border-gray-300 font-medium text-center">
                                {{$student->UTI_PRENOM}} {{ $student->UTI_NOM }}

                               
                                <form action="{{ url('/submit/' . $student->UTI_ID) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded shadow">
                                        Valider
                                    </button>
                                </form>
                            </th>
                            @foreach($aptitudesList as $aptitude)
                                @php
                                    $validationFound = $validationsList->first(function ($validation) use ($student, $aptitude) {
                                        return $validation->UTI_ID === $student->UTI_ID && $validation->APT_CODE === $aptitude->APT_CODE;
                                    });
                                @endphp

                                @if($validationFound && $validationFound->VALIDE === 1)
                                    <td class="px-4 py-2 border border-gray-300 bg-green-400 text-white text-center">
                                        Acquis
                                    </td>
                                @else
                                    <td class="px-4 py-2 border border-gray-300 bg-orange-400 text-white text-center">
                                        En cours
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
