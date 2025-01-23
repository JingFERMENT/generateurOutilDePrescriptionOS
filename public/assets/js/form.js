const campagneOptions = document.getElementById("id_campagne");
const formApporteurName = document.getElementById("formApporteurName");

// Get the id_campagne from a data attribute
idCampagne = campagneOptions.dataset.idCampagne;

// Display apporteur options based on idCampagne
displayCodeApporteurChoiceOptions(idCampagne);

// Store the selected value
let selectedApporteur = null;

function displayCodeApporteurChoiceOptions(idCampagne) {
  const apporteursOptions = document.getElementById("code_apporteur");
  
  // clear the previously responses
  apporteursOptions.innerHTML = "";

  // Fetch data for apporteurs
  fetch(`/form?id_campagne=${idCampagne}`)
    .then((response) => response.json())
    .then((data) => {
      
      // If no apporteurs are available
      if (data.length === 0) {
        formApporteurName.style.display = "none";
      } else {
        // Add a disabled placeholder option
        const placeHolderoption = document.createElement("option");

        placeHolderoption.selected = true;
        placeHolderoption.textContent = "-- Veuillez sélectionner le nom d'apporteur --";
        placeHolderoption.disabled = true;
        apporteursOptions.appendChild(placeHolderoption);

        // Add options for each apporteur for 2 cases : one or many apporteurs
        selectedApporteur = document.getElementById("formApporteurName").dataset.selecteurApporteur;

        data.forEach((apporteur) => {

          const option = document.createElement("option");
          option.value = apporteur.code_apporteur;
          option.textContent = apporteur.nom_apporteur;

          // Pre-select the option if it matches the selectedApporteur
          if (apporteur.code_apporteur === selectedApporteur) {
            option.selected = true;
          } 

          apporteursOptions.appendChild(option);

          //Show or hide the dropdown based on the number of apporteurs
          formApporteurName.style.display =
            data.length !== 1 ? "block" : "none";

          // If there’s only one apporteur, select it programmatically
          if (data.length === 1) {
          apporteursOptions.value = data[0].code_apporteur;
      }
        });
      }
    })
    .catch((error) => console.error(error))
}


campagneOptions.addEventListener("change", (event) => {
  const idCampagne = event.target.value; // get the target value
  displayCodeApporteurChoiceOptions(idCampagne);
});
