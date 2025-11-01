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
        <h1 class="text-3xl font-bold mb-6 text-center">Validation des Compétences</h1>

        <div class="max-w-7xl mx-auto bg-white p-4 shadow-md rounded-lg overflow-x-auto">
            <!-- Vérifiez si toutes les compétences nécessaires sont validées -->
            @if($nbCompValidated >= $nbComp)
                <div>
                    <h1>Validation des compétences disponibles</h1>
                    <form action="{{ route('validationcomp.show', ['userId' => $student->UTI_ID]) }}" method="POST" class="mt-2">
                        @csrf
                        <!-- Champs cachés pour transmettre les données -->
                        <input type="hidden" name="UTI_ID" value="{{ $student->UTI_ID }}">
                        <input type="hidden" name="UTI_NIVEAU" value="{{ $student->UTI_NIVEAU }}">

                        <button 
                            type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded shadow"
                            @if(session('success')) disabled @endif>
                            Valider
                        </button>
                    </form>
                </div>
            @else
                <!-- Si toutes les compétences ne sont pas validées -->
                <div>
                    <h1>Impossible de valider les compétences pour le niveau supérieur, toutes les compétences ne sont pas validées</h1>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
