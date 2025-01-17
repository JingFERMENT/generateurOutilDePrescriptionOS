const deleteButtonsApporteurs = document.querySelectorAll('.modalOpenCodeApporteurDeleteBtn');

const confirmButtonApporteur = document.querySelector('.deleteCodeApporteurBtn');

deleteButtonsApporteurs.forEach(deleteButtonApporteur => {
    deleteButtonApporteur.addEventListener('click', showConfirmationApporteurDelete )

    function showConfirmationApporteurDelete(){
        const apporteurId = deleteButtonApporteur.getAttribute('data-id');

        confirmButtonApporteur.setAttribute('data-id', apporteurId);
    }
});

confirmButtonApporteur.addEventListener('click', doDeleteCodeApporteur);

function doDeleteCodeApporteur(){
    const apporteurId = confirmButtonApporteur.getAttribute('data-id');

    window.location.href = "/deleteApporteur?id=" + apporteurId;
}