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
</head>

<body>
    @include('header')
    <div class="bg-[url('/img/underwater.png')]">
        <div class="form-container">
            <h1 class="font-bold text-[#004B85] text-center text-2xl m-4">Informations de la Séance</h1>
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
                                <button type="button" onclick="cancelEdit(this)"
                                    style="display: none;">Annuler</button>
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
                                    <input type="checkbox" name="presence[{{ $eleve->user->UTI_ID }}]"
                                        value="{{ $eleve->user->UTI_ID }}" checked>
                                </td>
                                <td>
                                    <div>
                                        @foreach ($seance->getAptEleve($eleve->user->UTI_ID) as $apt)
                                            <p><strong>{{ $apt->APT_LIBELLE }}</strong>
                                            <p>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <button type="button" onclick="transformRow(this)">Modifier</button>
                                    <button type="button" onclick="cancelEdit(this)"
                                        style="display: none;">Annuler</button>
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
    </div>

    <script>
        function transformRow(button) {
            const row = button.closest('tr');

            // Récupérer tous les labels généraux et spécifiques (label avec classe "s")
            const labels = row.querySelectorAll('label');
            const aptLabels = row.querySelectorAll('p'); // Labels spécifiques à la classe "s"

            // Remplacer tous les labels généraux par des inputs
            labels.forEach(label => {
                const value = label.textContent;
                const input = document.createElement('input');
                input.type = 'text';
                input.value = value;
                input.dataset.originalValue = value; // Sauvegarder la valeur originale
                label.replaceWith(input); // Remplacer le label par un input
            });

            // Remplacer les labels spécifiques (classe "s") par des selects
            aptLabels.forEach(label => {
                const value = label.textContent;

                // Créer un select
                const select = document.createElement('select');
                const option = document.createElement('option');
                option.value = value;
                option.textContent = value;
                select.appendChild(option); // Ajouter l'option au select

                select.dataset.originalValue = value; // Sauvegarder la valeur originale
                label.replaceWith(select); // Remplacer le label par le select
            });

            // Masquer le bouton "Modifier" et afficher le bouton "Annuler"
            button.style.display = 'none';
            row.querySelector('button[onclick="cancelEdit(this)"]').style.display = 'inline-block';
        }

        function cancelEdit(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input[type="text"]');
            const selects = row.querySelectorAll('select'); // Cibler les selects transformés

            // Remplacer les inputs par des labels
            inputs.forEach(input => {
                const value = input.dataset.originalValue;
                const label = document.createElement('label');
                label.textContent = value;
                input.replaceWith(label); // Remplacer l'input par un label
            });

            // Remplacer les selects par des labels
            selects.forEach(select => {
                const value = select.dataset.originalValue;
                const label = document.createElement('p');
                label.textContent = value;
                select.replaceWith(label); // Remplacer le select par un label
            });

            // Masquer le bouton "Annuler" et afficher le bouton "Modifier"
            button.style.display = 'none';
            row.querySelector('button[onclick="transformRow(this)"]').style.display = 'inline-block';
        }
    </script>
    @include('footer')
</body>

</html>
