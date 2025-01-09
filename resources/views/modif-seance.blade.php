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
    <h2>Informations de la Séance</h2>
    <form action="{{ route('seance-update', ['seance_id' => $seance->SEA_ID]) }}" method="POST">
        @csrf
        <input type="hidden" name="SEA_ID" value="{{ $seance->SEA_ID }}">

        <!-- Tableau pour les informations de la séance -->
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
                    <td><label>{{ $seance->SEA_ID }}</label></td>
                    <td><label>{{ $seance->getLieu()[0]->LI_NOM }}</label></td>
                    <td><label>{{ $seance->getFormation()[0]->FORM_LIBELLE }}</label></td>
                    <td><label>{{ $seance->SEA_DATE_DEB }}</label></td>
                    <td><label>{{ $seance->SEA_DATE_FIN }}</label></td>
                    <td>
                            <button type="button" onclick="transformRow(this)">Modifier</button>
                            <button type="button" onclick="cancelEdit(this)" style="display: none;">Annuler</button>
                        </td>
                </tr>
            </tbody>
        </table>

        <!-- Tableau pour afficher les élèves -->
        <table>
            <thead>
                <tr>
                    <th>Nom de l'élève</th>
                    <th>Nom de l'initiateur</th>  
                    <th>Presence</th>
                    <th>Aptitudes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eleves as $eleve)
                    @php
                        $initiateur = $eleve->getinitiator($seance->SEA_ID)[0];
                    @endphp
                    <tr>
                        <td><label>{{ $eleve->user->UTI_NOM }}</label></td>
                        <td><label>{{ $initiateur->user->UTI_NOM }}</label></td>
                        <td>
                            <input type="checkbox" name="presence[{{ $eleve->user->UTI_ID }}]" value="{{ $eleve->user->UTI_ID }}" checked>
                        </td>
                        <td>
                            <div>
                                @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                <label><strong>{{ $apt->APT_LIBELLE }}</strong></label>
                                <br>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <button type="button" onclick="transformRow(this)">Modifier</button>
                            <button type="button" onclick="cancelEdit(this)" style="display: none;">Annuler</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>
        <button type="submit">Enregistrer</button>
    </form>

    <?php
                $url = route('seance-update', ['seance_id' => $seance->SEA_ID]);
    ?>

<button id="evaluate" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded mx-auto" 
            onclick="window.location.href='<?php echo $url; ?>'">
        Supprimer
    </button>

</div>

<script>
    function transformRow(button) {
        const row = button.closest('tr');
        const labels = row.querySelectorAll('label');
        const strongs = row.querySelectorAll('strong');
        labels.forEach(label => {
            const value = label.textContent;
            const input = document.createElement('input');
            input.type = 'text';
            input.value = value;
            input.dataset.originalValue = value;
            label.replaceWith(input);
        });

        strongs.forEach(strong => {
            const value = strong.textContent;
            const select = document.createElement('select');
            select.type = 'text';
            select.value = value;
            select.dataset.originalValue = value;
            strong.replaceWith(select);
        });
        button.style.display = 'none';
        row.querySelector('button[onclick="cancelEdit(this)"]').style.display = 'inline-block';
    }

    function cancelEdit(button) {
        const row = button.closest('tr');
        const inputs = row.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            const value = input.dataset.originalValue;
            const label = document.createElement('label');
            label.textContent = value;
            input.replaceWith(label);
        });
        button.style.display = 'none';
        row.querySelector('button[onclick="transformRow(this)"]').style.display = 'inline-block';
    }
</script>

</body>
</html>
