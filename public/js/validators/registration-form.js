"use strict";
const typeEl = document.getElementById("registration_form_type");
const passwordInputEl = document.getElementById(
  "registration_form_plainPassword"
);
const confirmPasswordInputEl = document.getElementById(
  "registration_form_confirmedPassword"
);

const typeCheckBoxEl = document.getElementById("registration_form_user_type");

(function () {
  typeEl.value = "CUSTOMER";
})();

function validate() {}

//registration_form_user_type

function validaCPF(cpf) {
  // Extrai somente os números
  cpf = cpf.replace(/[^0-9]/g, "");

  // Verifica se foi informado todos os digitos corretamente
  if (cpf.length != 11) {
    return false;
  }

  // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
  if (cpf.match(/(\d)\1{10}/)) {
    return false;
  }

  // Faz o calculo para validar o CPF
  for (let t = 9; t < 11; t++) {
    let d = 0;
    let c = 0;
    for (d = 0, c = 0; c < t; c++) {
      d += cpf[c] * (t + 1 - c);
    }
    d = ((10 * d) % 11) % 10;
    if (cpf[c] != d) {
      return false;
    }
  }
  return true;
}

confirmPasswordInputEl.addEventListener("keyup", function () {
  const passwordAlertEl = document.getElementById("password-alert");
  const passwordInputValue = passwordInputEl.value;
  const confirmInputValue = this.value;

  let errorMessage = "";
  if (passwordInputValue != confirmInputValue) {
    errorMessage = "As senhas não conferem";
    this.setCustomValidity(errorMessage);
    passwordAlertEl.textContent = errorMessage;
  } else {
    this.setCustomValidity("");
    passwordAlertEl.textContent = "";
  }
});

typeCheckBoxEl.addEventListener("change", function () {
  console.log("Type Checkbox: ", this);
  if (this.checked) {
    typeEl.value = "FREELANCER";
  } else {
    typeEl.value = "CUSTOMER";
  }
});
