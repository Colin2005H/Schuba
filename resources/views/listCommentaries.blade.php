<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <body class="h-screen bg-gray-100 flex items-center justify-center">

        <!-- Conteneur du tableau centré -->
        <div class="w-3/4 max-w-4xl overflow-x-auto bg-white shadow-lg rounded-lg">
          <table class="min-w-full table-auto">
            <thead>
              <tr class="bg-gray-200">
                <th class="text-center py-4 px-6">NOM</th>
                <th class="text-center py-4 px-6">PRENOM</th>
                <th class="text-center py-4 px-6">COMMENTAIRE</th>
              </tr>
            </thead>
            <tbody>
               @foreach ($liste_eleve as $item)
     
                    <tr class="border-b border-gray-200">
                        <td class="text-center py-4 px-6">{{$item->UTI_NOM}}></td>
                        <td class="text-center py-4 px-6">{{$item->UTI_PRENOM}}</td>
                        <td class="text-center py-4 px-6">{{$item->EVA_COMMENTAIRE}}</td>
                    </tr>

              @endforeach
              
            </tbody>
          </table>
        </div>
</body>
</html>