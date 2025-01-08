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

<div class="form-container">
    <h2>Récapitulatif de la Séance</h2>
    <form action="{{ route('seance-store') }}" method="POST">
        @csrf
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
                    <tr>
                        <td>{{ $eleve->user->UTI_NOM }}</td>
                        <td>
                            <input type="checkbox" name="presence[{{ $eleve->id }}]" value="1">
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
                        <select name="evaluation[{{ $eleve->id }}][{{ $apt->APT_CODE }}]">
                            <option>non évaluée</option>
                            <option>en cours d'acquisition</option>
                            <option>acquise</option>
                        </select>
                            @endforeach
                        
                        </td>
                        <td>
                            
                                <div>
                                    <textarea name="commentaire[{{ $eleve->id }}][{{ $apt->APT_CODE }}]" rows="2" placeholder="Commentaire..."></textarea>
                                </div>
                            
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
