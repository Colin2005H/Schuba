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
                <th class="text-center py-4 px-6">DATE DE CREATION</th>
                <th class="text-center py-4 px-6" colspan="2">GESTION</th>
              </tr>
            </thead>
            <tbody>
               @foreach ($liste_eleve as $item)
     
                    <tr class="border-b border-gray-200">
                        <td class="text-center py-4 px-6">{{$item->UTI_NOM}}></td>
                        <td class="text-center py-4 px-6">{{$item->UTI_PRENOM}}</td>
                        <td class="text-center py-4 px-6">{{$item->UTI_MAIL}}</td>
                        <td class="text-center py-4 px-6">{{$item->UTI_DATE_CREATION}}</td>
                        <td class="text-center py-4 px-6"><a href="{{ route('modifierCompte', ['id' => $item->UTI_ID]) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-orange-300">
                          Modifier
                          </a>
                        </td>
                        <td class="text-center py-4 px-6"><button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-red-300" onclick="confirmDelete()" href ="modifier" >supprimer</button></td>
                    </tr>

              @endforeach
              
            </tbody>
          </table>
        </div>

        <script>
            function confirmDelete() {
              const userConfirmed = confirm("Êtes-vous sûr de vouloir supprimer cet élément ?");
              if (userConfirmed) {
                alert("L'élément a été supprimé.");
                // Ajoute ici la logique de suppression, par exemple une requête à un serveur
              } else {
                alert("La suppression a été annulée.");
              }
            }
          </script>
</body>
</html>