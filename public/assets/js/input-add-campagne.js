let userSelectedApporteurs = [];

const multiInput = document.querySelector("multi-input");

// add the selected values
multiInput.addEventListener("modify", () => {
  userSelectedApporteurs = multiInput.getValues();
  
});

const addForm = document.getElementById("addForm");

addForm.addEventListener("submit", (event) => {
  event.preventDefault(); // Prevent default form submission

  //addform is the tagret
  const addForm = event.target;
 
  // Append selected values as hidden inputs
    userSelectedApporteurs.forEach((value) => {
    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = `apporteurs[]`; // PHP will treat it as an array
    hiddenInput.value = value;
    addForm.appendChild(hiddenInput);
  });

  // Submit the form programmatically
  addForm.submit();
});
