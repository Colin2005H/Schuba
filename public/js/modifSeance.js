function transformRow(button) {
    const row = button.closest('tr');
    const labels = row.querySelectorAll('label');
    const aptLabels = row.querySelectorAll('p');
    const dateLabels = row.querySelectorAll('td:nth-child(4) label, td:nth-child(5) label');

    labels.forEach(label => {
        const value = label.textContent;
        const input = document.createElement('input');
        input.type = 'text';
        input.value = value;
        input.dataset.originalValue = value;
        label.replaceWith(input);
    });

    aptLabels.forEach(label => {
        const value = label.textContent;
        const select = document.createElement('select');
        const option = document.createElement('option');
        option.value = value;
        option.textContent = value;
        select.appendChild(option);
        select.dataset.originalValue = value;
        label.replaceWith(select);
    });

    dateLabels.forEach(label => {
        const value = label.textContent;
        const input = document.createElement('input');
        input.type = 'date';
        input.value = new Date(value).toISOString().split('T')[0];
        input.dataset.originalValue = value;
        label.replaceWith(input);
    });

    button.style.display = 'none';
    row.querySelector('button[onclick="cancelEdit(this)"]').style.display = 'inline-block';
    row.querySelector('button[onclick="deleteRow(this)"]').style.display = 'inline-block';
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
