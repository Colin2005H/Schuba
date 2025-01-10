<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations de la Séance</title>
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
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script defer src="{{ asset('js/modifSeance.js') }}"></script>
</head>

<body>

    <div class="form-container">
        <h2>Informations de la Séance</h2>
        <form id="seanceForm" action="{{ route('seance.update') }}" method="POST">
            @csrf
            <input type="hidden" name="SEA_ID" value="{{ $seance->SEA_ID }}">
            <input type="hidden" id="action" name="action" value="">
            <table>
                <thead>
                    <tr>
                        <th>Id de la séance</th>
                        <th>Lieu</th>
                        <th>Niveau de la formation</th>
                        <th>Date début de la séance</th>
                        <th>Date fin de la séance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p>{{ $seance->SEA_ID }}</p>
                        </td>
                        <td><label>{{ $seance->getLieu()[0]->LI_NOM }}</label></td>
                        <td>
                            <p>{{ $seance->getFormation()[0]->FORM_LIBELLE }}</p>
                        </td>
                        <td><label>{{ $seance->SEA_DATE_DEB }}</label></td>
                        <td><label>{{ $seance->SEA_DATE_FIN }}</label></td>
                        <td>
                            <button type="button" onclick="transformRow(this)">Modifier</button>
                            <button type="button" onclick="cancelEdit(this)" style="display: none;">Annuler</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'élève</th>
                        <th>Nom de l'initiateur</th>
                        <th>Présence</th>
                        <th>Aptitudes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="elevesTableBody">
                    @foreach ($eleves as $eleve)
                        @php
                            $initiateur = $eleve->getinitiator($seance->SEA_ID)[0];
                        @endphp
                        <tr>
                            <td><label>{{ $eleve->user->UTI_NOM }}</label></td>
                            <td><label>{{ $initiateur->user->UTI_NOM }}</label></td>
                            <td>
                                <input type="checkbox" name="presence[{{ $eleve->user->UTI_ID }}]"
                                    value="{{ $eleve->user->UTI_ID }}" checked>
                            </td>
                            <td>
                                <div>
                                    @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                        <p><strong>{{ $apt->APT_LIBELLE }}</strong></p>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <button type="button" onclick="transformRow(this)">Modifier</button>
                                <button type="button" onclick="deleteRow(this)"
                                    style="display: none;">Supprimer</button>
                                <button type="button" onclick="cancelEdit(this)"
                                    style="display: none;">Annuler</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" onclick="addRow()">Ajouter un élève</button>

            <br>
            <button type="button" onclick="setActionAndSubmit('update')">Enregistrer</button>
            <button type="button" onclick="setActionAndSubmit('delete')"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded mx-auto">Supprimer</button>
        </form>
    </div>
</body>

</html>
