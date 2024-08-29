let selectedFiles = {
    images: [],
    documents: []
};

function displayFiles(inputElement, fileType) {
    const displayContainer = document.getElementById(fileType === 'images' ? 'selected-files-images' : 'selected-files-documents');
    const newFiles = Array.from(inputElement.files);

    // Ajouter les nouveaux fichiers à la liste des fichiers sélectionnés
    newFiles.forEach((file) => {
        selectedFiles[fileType].push(file);
    });

    // Réinitialiser l'affichage
    updateFileList(displayContainer, fileType, inputElement);
}

function removeSelectedFile(index, fileType) {
    // Retirer le fichier sélectionné de la liste
    selectedFiles[fileType].splice(index, 1);

    // Rafraîchir l'affichage des fichiers
    const displayContainer = document.getElementById(fileType === 'images' ? 'selected-files-images' : 'selected-files-documents');
    updateFileList(displayContainer, fileType);
}

function updateFileList(displayContainer, fileType, inputElement) {
    displayContainer.innerHTML = '';

    selectedFiles[fileType].forEach((file, index) => {
        const fileElement = document.createElement('div');
        fileElement.className = 'file-item d-flex justify-content-between align-items-center';

        const fileNameElement = document.createElement('span');
        fileNameElement.className = 'file-name';
        fileNameElement.textContent = file.name;

        const removeButton = document.createElement('span');
        removeButton.className = 'remove-file';
        removeButton.textContent = '×';
        removeButton.style.cursor = 'pointer';
        removeButton.onclick = function() {
            removeSelectedFile(index, fileType);
        };

        fileElement.appendChild(fileNameElement);
        fileElement.appendChild(removeButton);
        displayContainer.appendChild(fileElement);
    });

    // Réinitialiser la valeur de l'input pour permettre la sélection répétée du même fichier si nécessaire
    if (inputElement) {
        inputElement.value = '';
    }
}
