
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
    const selects = row.querySelectorAll('select');  // Cibler les selects transformés

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

function setActionAndSubmit(action) {
    // Set the action in the hidden input
    document.getElementById('action').value = action;
    // Submit the form
    document.getElementById('seanceForm').submit();
}
