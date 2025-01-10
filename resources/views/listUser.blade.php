<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

@include('header')

<body class="h-screen bg-gray-100 ">

    <!-- Conteneur du tableau centré -->
    <div class="bg-[url('/img/scub1.png')] h-full bg-cover bg-no-repeat bg-center p-10">
        <div class="w-3/4 max-w-5xl max-h-96 overflow-y-scroll bg-white shadow-lg rounded-lg justify-self-center">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="text-center py-4 px-6">NOM</th>
                        <th class="text-center py-4 px-6">PRENOM</th>
                        <th class="text-center py-4 px-6">NIVEAU</th>
                        <th class="text-center py-4 px-6">DATE DE CERTIFICAT</th>
                        <th class="text-center py-4 px-6">NIVEAU</th>
                        <th class="text-center py-4 px-6" colspan="2">GESTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($liste_eleve as $item)
                        @if ($item->UTI_SUPPRIME == 0)
                            <td class="text-center py-4 px-6">{{ $item->UTI_NOM }}</td>
                            <td class="text-center py-4 px-6">{{ $item->UTI_PRENOM }}</td>
                            @switch($item->UTI_NIVEAU)
                                @case(0)
                                    <td class="text-center py-4 px-6">PAS DE NIVEAU</td>
                                @break

                                @case($item->UTI_NIVEAU > 0 && $item->UTI_NIVEAU < 5)
                                    <td class="text-center py-4 px-6">N{{ $item->UTI_NIVEAU }}</td>
                                @break

                                @case(5)
                                    <td class="text-center py-4 px-6">MF1</td>
                                @break

                                @case(6)
                                    <td class="text-center py-4 px-6">MF1</td>
                                @break
                            @endswitch


                            <td class="text-center py-4 px-6">{{ $item->UTI_DATE_CERTIFICAT }}</td>
                            <td class="text-center py-4 px-6">{{ $item->UTI_MAIL }}</td>

                            <td class="text-center py-4 px-6"><a
                                    href="{{ route('modifierCompte', ['id' => $item->UTI_ID]) }}"
                                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-orange-300">
                                    Modifier
                                </a>
                            </td>

                            <form action="/listUser" method="post">
                                @csrf
                                <td class="text-center py-4 px-6"><button name="action" value="{{ $item->UTI_ID }}"
                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-red-300"
                                        onclick="submitDelete()" href ="modifier">Supprimer</button></td>
                            </form>
                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden" onclick="closeAlert()"></div>
    </div>
    @include('footer')

    <script>
        // Simuler l'action de soumission du formulaire
        function submitDelete() {
            alert("Compte supprimé avec succès!");
            closeAlert(); // Fermer l'alerte après soumission
        }
    </script>
</body>

</html>
