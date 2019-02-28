function validateInput(inputId, pattern, errorMessagge) {

  let element = document.getElementById(inputId);

  element.pattern = pattern;
  element.setCustomValidity("");

  if (element.validity.valid) {
    return true;
  } else {
    element.setCustomValidity(errorMessagge);
    return false

  }
}

function setInvalidInputStyle(inputId) {

  var element = document.getElementById(inputId);

  element.style.borderColor = "red";
  element.style.borderStyle = "solid";
  element.style.borderWidth = "1.5";
  element.style.backgroundColor = "#FFEFF0";

}

function setValidInputStyle(inputId) {

  var element = document.getElementById(inputId);

  element.style.borderColor = "#9fcbe1";
  element.style.borderStyle = "solid";
  element.style.borderWidth = "1.5";
  element.style.backgroundColor = "#ecf5f9";

}

function validateUsernameInput(inputId) {

  event.preventDefault();

  let pattern = "[A-Za-z0-9_-]{1,15}";
  let errorMessagge = "Introduce un usuario valido"

  return validateInput(inputId, pattern, errorMessagge)

}

function validateEmailInput(inputId) {  

  let pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$";
  let errorMessagge = "Introcude un correo valido";

  return validateInput(inputId, pattern, errorMessagge)

}

function validatePasswordInput(inputId) {

  event.preventDefault();

  let pattern = "[A-Za-z0-9_-]{6,}";
  let errorMessagge = "Introduce una contraseña valida"

  return validateInput(inputId, pattern, errorMessagge)

}

function validatePassworConfirmationInputs() {

  var password = document.getElementById('password');
  var passwordConfirmation = document.getElementById('passwordConfirmation');
  passwordConfirmation.setCustomValidity("");

  if (password.value != passwordConfirmation.value) {
    setInvalidInputStyle('passwordConfirmation')
    passwordConfirmation.setCustomValidity("Las contraseñas no coinciden");
    return false;
  } else {
    setValidInputStyle('passwordConfirmation')
    return true;
  }

}


function usernameValidateListener(event){
  
  event.preventDefault();

  let element = event.target;
  let elementId = element.id;

  element.addEventListener('input', usernameValidateListener);

  validateUsernameInput(elementId) ? setValidInputStyle(elementId) : setInvalidInputStyle(elementId);

}

function emailValidateListener(event){

  event.preventDefault();

  let element = event.target;
  let elementId = element.id;

  element.addEventListener('input', emailValidateListener);
  validateEmailInput(elementId) ? setValidInputStyle(elementId) : setInvalidInputStyle(elementId);
}

function passwordValidateListener(event){

  event.preventDefault();

  let element = event.target;
  let elementId = element.id;

  element.addEventListener('input', passwordValidateListener);
  validatePasswordInput(elementId) ? setValidInputStyle(elementId) : setInvalidInputStyle(elementId);
}