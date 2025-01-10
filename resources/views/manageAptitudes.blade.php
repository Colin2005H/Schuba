<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
@include('header')

<body class="h-screen bg-gray-100 center">

    <!-- Container centered -->
    <div class="w-3/4 max-w-5xl bg-white shadow-lg rounded-lg overflow-hidden mx-1000 my-1000">
        <!-- Section qui limite la hauteur et active le défilement -->
        <div class="overflow-y-scroll max-h-96">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 sticky top-0 z-10">
                    <tr>
                        <th class="text-center py-4 px-6">Compétence</th>
                        <th class="text-center py-4 px-6">Aptitude</th>
                        <th class="text-center py-4 px-6">Description</th>
                        <th class="text-center py-4 px-6" colspan="2">GESTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aptitudesList as $aptitude)
                        <tr class="border-b">
                            <td class="text-center py-4 px-6">{{ $aptitude->CPT_ID }}</td>
                            <td class="text-center py-4 px-6">{{ $aptitude->APT_CODE }}</td>
                            <td class="text-center py-4 px-6">{{ $aptitude->APT_LIBELLE }}</td>
                            <td class="text-center py-4 px-6">
                                <form action="{{ route('manageAptitudes.show') }}" method="post">
                                    @csrf
                                    <input name="aptitudeId" type="hidden" value="{{ $aptitude->APT_CODE }}">
                                    <input name="description" type="text" value="Nouvelle description">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded shadow"
                                        @if (session('success')) disabled @endif>
                                        Valider
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
