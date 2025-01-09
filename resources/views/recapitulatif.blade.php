<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif de la Séance</title>
    <style>
        .form-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@include('header')
<div class="form-container">
    <h2>Récapitulatif de la Séance</h2>
    <form action="{{ route('seance-store') }}" method="POST">

        @csrf
        <input type="hidden" name="SEA_ID" value="{{ $seance->SEA_ID }}">
        <table>
            <thead>
                <tr>
                    <th>Nom de l'élève</th>
                    <th>Présence</th>
                    <th>Aptitude à Évaluer</th>
                    <th>Évaluation</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleves as $eleve)
                    @php
                        $isInitiateur = $currentUser->UTI_ID === $eleve->getInitiator($seance->SEA_ID)[0]->user->UTI_ID;
                    @endphp
                    <tr>
                        <td>{{ $eleve->user->UTI_NOM }}</td>
                        <td>
                            <input type="checkbox" name="presence[{{ $eleve->user->UTI_ID }}]" value="{{ $eleve->user->UTI_ID }}" {{ $isInitiateur ? '' : 'disabled' }} checked>
                        </td>
                        <td>
                            @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                <div>
                                    <strong>{{ $apt->APT_LIBELLE }}</strong>
                                </div>
                            @endforeach
                        </td>
                        <td>
    @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
        <?php
            $evaluationValue = isset($default[$eleve->user->UTI_ID][$apt->APT_CODE]) ? $default[$eleve->user->UTI_ID][$apt->APT_CODE]['evaluation'] : null;
        ?>
        <select name="evaluation[{{ $eleve->user->UTI_ID }}][{{ $apt->APT_CODE }}]" {{ $isInitiateur ? '' : 'disabled' }}>
            <option value="Non évaluée" 
                {{ $evaluationValue === 'Non évaluée' ? 'selected' : '' }}>
                Non évaluée
            </option>
            <option value="En cours" 
                {{ $evaluationValue === 'En cours' ? 'selected' : '' }}>
                En cours
            </option>
            <option value="Acquis" 
                {{ $evaluationValue === 'Acquis' ? 'selected' : '' }}>
                Acquis
            </option>
        </select>
    @endforeach
</td>


                        <td>
                            @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                <div>
                                    <textarea name="commentaire[{{ $eleve->user->UTI_ID }}][{{ $apt->APT_CODE }}]" rows="2" placeholder="Commentaire..." {{ $isInitiateur ? '' : 'disabled' }}>
                                        {{ isset($default[$eleve->user->UTI_ID][$apt->APT_CODE]) ? $default[$eleve->user->UTI_ID][$apt->APT_CODE]['commentaire'] : '' }}
                                    </textarea>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <button type="submit">Enregistrer</button>
    </form>
</div>

</body>
</html>
