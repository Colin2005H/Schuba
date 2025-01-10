<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Menbres</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@include('header')

<body>
    <div class="bg-[url('/img/underwater.png')] h-full bg-cover bg-no-repeat bg-center p-10 justify-items-center">

        <h1 class="font-bold text-[#ffffff] text-center text-2xl m-4">Liste des élèves</h1>
        <div
            class="w-3/4 max-w-5xl scalable overflow-y-scroll mb-16 max-h-96 bg-white shadow-lg rounded-lg flex items-center justify-center mx-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="text-center py-4 px-6">NOM</th>
                        <th class="text-center py-4 px-6">PRENOM</th>
                        <th class="text-center py-4 px-6">NIVEAU</th>
                        <th class="text-center py-4 px-6">MAIL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentList as $item)
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

                            <td class="text-center py-4 px-6">{{ $item->UTI_MAIL }}</td>

                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>

<h1 class="font-bold text-[#004B85] text-center text-2xl m-4">Liste des initiateurs</h1>
<div class="w-3/4 max-w-5xl scalable overflow-y-scroll mb-16 max-h-96 bg-white shadow-lg rounded-lg flex items-center justify-center mx-auto">
    <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-gray-200">
            <th class="text-center py-4 px-6">NOM</th>
            <th class="text-center py-4 px-6">PRENOM</th>
            <th class="text-center py-4 px-6">NIVEAU</th>
            <th class="text-center py-4 px-6">MAIL</th>
          </tr>
        </thead>
        <tbody>
           @foreach ($initiatorList as $item)
            @if($item->UTI_SUPPRIME==0)

                    <td class="text-center py-4 px-6">{{$item->UTI_NOM}}</td>
                    <td class="text-center py-4 px-6">{{$item->UTI_PRENOM}}</td>
                    @switch($item->UTI_NIVEAU)
                        @case(0)
                            <td class="text-center py-4 px-6">PAS DE NIVEAU</td>
                            @break
                        @case($item->UTI_NIVEAU > 0 && $item->UTI_NIVEAU < 5 )
                            <td class="text-center py-4 px-6">N{{$item->UTI_NIVEAU}}</td>
                            @break
                        @case(5)
                            <td class="text-center py-4 px-6">MF1</td>
                            @break
                        @case(6)
                            <td class="text-center py-4 px-6">MF1</td>
                            @break

                    @endswitch

                            <td class="text-center py-4 px-6">{{ $item->UTI_MAIL }}</td>

                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @include('footer')




</body>

</html>
