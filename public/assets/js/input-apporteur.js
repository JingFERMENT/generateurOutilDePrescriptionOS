// codes apporteurs pre-rempli
const prefilledInputs = document.querySelectorAll(".pre-rempli");

const multiInput = document.querySelector("multi-input");

// Init previously selected values :
let userSelectedApporteurs = Array.from(prefilledInputs).map(
  (input) => input.value
);

// add Item one by one
prefilledInputs.forEach((prefilledInput) =>
  multiInput._addItem(prefilledInput.value)
);

// add the selected values
multiInput.addEventListener("modify", () => {
  userSelectedApporteurs = multiInput.getValues();
});

document.getElementById("updatedForm").addEventListener("submit", (event) => {
  event.preventDefault(); // Prevent default form submission

  //update form is the tagret
  const updatedForm = event.target;

  // Append selected values as hidden inputs
    userSelectedApporteurs.forEach((value) => {
    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = `apporteurs[]`; // PHP will treat it as an array
    hiddenInput.value = value;
    updatedForm.appendChild(hiddenInput);
  });

  // Submit the form programmatically
  updatedForm.submit();
});
