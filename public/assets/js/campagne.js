
// Sélectionner tous les boutons permettant d'ouvrir le modal de suppression
const deleteButtonsCampagnes = document.querySelectorAll('.modalOpenCodeCampagneDeleteBtn');

// Sélectionner le bouton de confirmation à l'intérieur du modal de suppression
const confirmDeleteButtonCampagne = document.querySelector('.deleteCampagneBtn');

// Ajouter un gestionnaire d'événement à chaque bouton de suppression pour afficher le modal de confirmation
deleteButtonsCampagnes.forEach(deleteButtonCampagne => {
    
    deleteButtonCampagne.addEventListener('click', showConfirmationCampagneDelete)

    function showConfirmationCampagneDelete() { 
        // Récupérer l'ID de la campagne à supprimer depuis l'attribut 'data-id' du bouton cliqué
        const campagneId = deleteButtonCampagne.getAttribute('data-id');
        
        // Associer l'ID de la campagne au bouton de confirmation dans le modal
        confirmDeleteButtonCampagne.setAttribute('data-id', campagneId); // associer l'ID au bouton de confirmation 
    }

})

// Ajouter un gestionnaire d'événement pour effectuer la suppression lorsque l'utilisateur confirme
confirmDeleteButtonCampagne.addEventListener('click', doDeleteCodeCampagne);

/**
 * Effectue la suppression de la campagne en redirigeant vers le contrôleur backend
 * avec l'ID de la campagne passé en paramètre dans l'URL.
 */
function doDeleteCodeCampagne(){

    // Récupérer l'ID de la campagne à partir de l'attribut 'data-id' du bouton de confirmation
    const campagneId = confirmDeleteButtonCampagne.getAttribute('data-id');
    
    // Rediriger l'utilisateur vers le contrôleur PHP en passant l'ID en paramètre dans l'URL
    window.location.href = "/deleteCampagne?id=" + campagneId;

}