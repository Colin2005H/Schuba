function transformRow(button) {
    const row = button.closest('tr');
    const labels = row.querySelectorAll('label');


    labels.forEach(label => {
        const value = label.textContent;
        const input = document.createElement('input');
        input.type = 'text';
        input.value = value;
        input.dataset.originalValue = value;
        label.replaceWith(input);
    });

    button.style.display = 'none';
    row.querySelector('button[onclick="cancelEdit(this)"]').style.display = 'inline-block';
    row.querySelector('button[onclick="deleteRow(this)"]').style.display = 'inline-block';

    // Add "Confirmer" button
    const confirmButton = document.createElement('button');
    confirmButton.type = 'button';
    confirmButton.textContent = 'Confirmer';
    confirmButton.onclick = function() { confirmEdit(this); };
    row.querySelector('td:last-child').appendChild(confirmButton);

    // Add buttons for adding/removing aptitudes
    const aptitudeCell = row.querySelector('td:nth-child(4)');
    const addAptitudeButton = document.createElement('button');
    addAptitudeButton.type = 'button';
    addAptitudeButton.textContent = 'Ajouter Aptitude';
    addAptitudeButton.onclick = function() { addAptitude(this); };

    const removeAptitudeButton = document.createElement('button');
    removeAptitudeButton.type = 'button';
    removeAptitudeButton.textContent = 'Supprimer Aptitude';
    removeAptitudeButton.onclick = function() { removeAptitude(this); };

    aptitudeCell.appendChild(addAptitudeButton);
    aptitudeCell.appendChild(removeAptitudeButton);
}
    

function confirmEdit(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input[type="text"], input[type="date"]');
    const selects = row.querySelectorAll('select');

    // Remplacer les champs modifiés par des labels
    inputs.forEach(input => {
        const value = input.value;
        const label = document.createElement('label');
        label.textContent = value;
        input.replaceWith(label);
    });

    // Remplacer les selects par des paragraphes
    selects.forEach(select => {
        const value = select.value;
        const label = document.createElement('p');
        label.textContent = value;
        select.replaceWith(label);
    });

    // Supprimer le bouton "Confirmer"
    button.remove();

    // Rendre visible les boutons "Modifier" et "Annuler"
    row.querySelector('button[onclick="transformRow(this)"]').style.display = 'inline-block';
    row.querySelector('button[onclick="cancelEdit(this)"]').style.display = 'none';
    row.querySelector('button[onclick="deleteRow(this)"]').style.display = 'none';

    // Supprimer les boutons "Ajouter Aptitude" et "Supprimer Aptitude"
    const aptitudeCell = row.querySelector('td:nth-child(4)');
    const addAptitudeButton = aptitudeCell.querySelector('button[textContent="Ajouter Aptitude"]');
    const removeAptitudeButton = aptitudeCell.querySelector('button[textContent="Supprimer Aptitude"]');

    if (addAptitudeButton) addAptitudeButton.remove();
    if (removeAptitudeButton) removeAptitudeButton.remove();
}



function addAptitude(button) {
    const aptitudeCell = button.closest('td');
    const existingInputs = aptitudeCell.querySelectorAll('input[type="select"]');

    if (existingInputs.length < 3) {
        const input = document.createElement('input');
        input.type = 'select';
        input.name = 'new_aptitudes[]';
        input.placeholder = 'Nouvelle aptitude';
        aptitudeCell.insertBefore(input, button);
    } else {
        alert('Un élève ne peut pas avoir plus de 3 aptitudes.');
    }
}

function removeAptitude(button) {
    const aptitudeCell = button.closest('td');
    const inputs = aptitudeCell.querySelectorAll('input[type="select"]');
    
    if (inputs.length > 0) {
        inputs[inputs.length - 1].remove();
    }
}



function cancelEdit(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input[type="text"], input[type="date"]');
    const selects = row.querySelectorAll('select');

    inputs.forEach(input => {
        const value = input.dataset.originalValue;
        const label = document.createElement('label');
        label.textContent = value;
        input.replaceWith(label);
    });

    selects.forEach(select => {
        const value = select.dataset.originalValue;
        const label = document.createElement('p');
        label.textContent = value;
        select.replaceWith(label);
    });

    button.style.display = 'none';
    row.querySelector('button[onclick="transformRow(this)"]').style.display = 'inline-block';
    row.querySelector('button[onclick="deleteRow(this)"]').style.display = 'none';
}

function deleteRow(button) {
    const row = button.closest('tr');
    row.remove();
}

function addRow() {
    const tableBody = document.getElementById('elevesTableBody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td><input type="text" name="new_eleve_name[]" placeholder="Nom de l'élève"></td>
        <td><input type="text" name="new_initiateur_name[]" placeholder="Nom de l'initiateur"></td>
        <td><input type="checkbox" name="new_presence[]"></td>
        <td><input type="text" name="new_aptitudes[]" placeholder="Aptitudes"></td>
        <td>
            <button type="button" onclick="confirmRow(this)">Confirmer</button>
            <button type="button" onclick="deleteRow(this)">Annuler</button>
        </td>
    `;

    tableBody.appendChild(newRow);
}

function confirmRow(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input[type="text"]');

    inputs.forEach(input => {
        const value = input.value;
        const label = document.createElement('label');
        label.textContent = value;
        input.replaceWith(label);
    });

    const confirmButton = row.querySelector('button[onclick="confirmRow(this)"]');
    const cancelButton = row.querySelector('button[onclick="deleteRow(this)"]');

    confirmButton.remove();
    cancelButton.remove();

    const modifyButton = document.createElement('button');
    modifyButton.type = 'button';
    modifyButton.textContent = 'Modifier';
    modifyButton.onclick = function() { transformRow(modifyButton); };
    row.querySelector('td:last-child').appendChild(modifyButton);
}
