<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif de la Séance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

@include('header')

<div class="w-full p-6 bg-white border border-gray-300 rounded-lg shadow-md sm:p-8 my-10 overflow-x-auto">
      

    <form action="{{ route('seance-store') }}" method="POST">

              <input type="hidden" name="SEA_ID" value="{{ $seance->SEA_ID }}">
   <f

            <table class="table-auto border-collapse mb-6 w-full">

        <input type="hidden" name="SEA_ID" value="{{ $seance->SEA_ID }}">

        <table class="table-auto border-collapse mb-6 w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 bg-gray-100">Nom de l'élève</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 bg-gray-100">Présence</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 bg-gray-100">Aptitude à Évaluer</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 bg-gray-100">Évaluation</th>
                    <th class="px-4 py-2 text-left font-medium text-gray-600 bg-gray-100">Commentaire</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleves as $eleve)
                    @php
                        $isInitiateur = $currentUser->UTI_ID === $eleve->getInitiator($seance->SEA_ID)[0]->user->UTI_ID;
                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $eleve->user->UTI_NOM }}</td>
                        <td class="px-4 py-2">
                            <input type="checkbox" name="presence[{{ $eleve->user->UTI_ID }}]" value="{{ $eleve->user->UTI_ID }}" {{ $isInitiateur ? '' : 'disabled' }} checked class="form-checkbox">
                        </td>
                        <td class="px-4 py-2">
                            @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                <div class="text-sm text-gray-600">
                                    <strong>{{ $apt->APT_LIBELLE }}</strong>
                                </div>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                            @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                <?php
                                    $evaluationValue = isset($default[$eleve->user->UTI_ID][$apt->APT_CODE]) ? $default[$eleve->user->UTI_ID][$apt->APT_CODE]['evaluation'] : null;
                                ?>
                                <select name="evaluation[{{ $eleve->user->UTI_ID }}][{{ $apt->APT_CODE }}]" {{ $isInitiateur ? '' : 'disabled' }} class="form-select mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="Non évaluée" {{ $evaluationValue === 'Non évaluée' ? 'selected' : '' }}>Non évaluée</option>
                                    <option value="En cours" {{ $evaluationValue === 'En cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="Acquis" {{ $evaluationValue === 'Acquis' ? 'selected' : '' }}>Acquis</option>
                                </select>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                            @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                <div>
                                    <textarea name="commentaire[{{ $eleve->user->UTI_ID }}][{{ $apt->APT_CODE }}]" rows="2" placeholder="Commentaire..." {{ $isInitiateur ? '' : 'disabled' }} class="form-textarea mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" style="min-height: 50px;">{{ isset($default[$eleve->user->UTI_ID][$apt->APT_CODE]) ? $default[$eleve->user->UTI_ID][$apt->APT_CODE]['commentaire'] : '' }}</textarea>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="px-6 py-3 mt-4 text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm font-semibold">Enregistrer</button>
    </form>
</div>

</body>
</html>
