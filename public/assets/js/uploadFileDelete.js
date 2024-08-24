function displayFileName(inputElement) {
    const fileNameElement = inputElement.closest('.upload-zone').querySelector('.file-name');
    const removeButton = inputElement.closest('.upload-zone').querySelector('.remove-file');
    const files = inputElement.files;

    if (files.length > 0) {
        fileNameElement.textContent = files[0].name;
        removeButton.classList.remove('d-none');
    } else {
        fileNameElement.textContent = '';
        removeButton.classList.add('d-none');
    }
}

function removeFile(inputId, displayId) {
    // Utilisation d'un sélecteur plus précis pour trouver l'élément d'entrée
    const inputElement = document.querySelector(`input[id="${inputId}"]`);
    const displayElement = document.getElementById(displayId);

    if (inputElement) {
        // Clear the input value
        inputElement.value = '';

        // Reset the display
        displayElement.querySelector('.file-name').textContent = '';
        displayElement.querySelector('.remove-file').classList.add('d-none');
    } else {
        console.error(`Element with id "${inputId}" not found.`);
    }
}