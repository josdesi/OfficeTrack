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

function applyInvalidInputStyle(inputId) {

  var element = document.getElementById(inputId);

  element.style.borderColor = "red";
  element.style.borderStyle = "solid";
  element.style.borderWidth = "1.5";
  element.style.backgroundColor = "#FFEFF0";

}

function applyValidInputStyle(inputId) {

  var element = document.getElementById(inputId);

  element.style.borderColor = "#9fcbe1";
  element.style.borderStyle = "solid";
  element.style.borderWidth = "1.5";
  element.style.backgroundColor = "#ecf5f9";

}

function validateUsernameField(inputId) {

  event.preventDefault();

  let pattern = "[A-Za-z0-9_-]{1,15}";
  let errorMessagge = "Introduce un usuario valido"

  return validateInput(inputId, pattern, errorMessagge)

}

function validateEmailField(inputId) {

  let pattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$";
  let errorMessagge = "Introcude un correo valido";

  return validateInput(inputId, pattern, errorMessagge)

}

function validatePasswordField(inputId) {

  event.preventDefault();

  let pattern = "[A-Za-z0-9_-]{6,}";
  let errorMessagge = "Introduce una contraseña valida"

  return validateInput(inputId, pattern, errorMessagge)

}

function onUsernameChange(event) {

  event.preventDefault();

  let element = event.target;
  let elementId = element.id;

  element.addEventListener('input', onUsernameChange);

  validateUsernameField(elementId) ? applyValidInputStyle(elementId) : applyInvalidInputStyle(elementId);

}

function onEmailChange(event) {

  event.preventDefault();

  let element = event.target;
  let elementId = element.id;

  element.addEventListener('input', onEmailChange);
  
  validateEmailField(elementId) ? applyValidInputStyle(elementId) : applyInvalidInputStyle(elementId);
}

function onPasswordChange(event) {

  event.preventDefault();

  let password = event.target;
  let passwordId = password.id;

  validatePasswordField(passwordId) ? applyValidInputStyle(passwordId) : applyInvalidInputStyle(passwordId);

}

function onPasswordConfirmationChange(event, passwordInputId) {
  
  event.preventDefault();

  let password = document.getElementById(passwordInputId);

  let confirmation = event.target;
  let confirmationId = confirmation.id;

  confirmation.setCustomValidity("");

  if (password.value != passwordConfirmation.value) {
    applyInvalidInputStyle(confirmationId)
    confirmation.setCustomValidity("Las contraseñas no coinciden");
  } else {
    applyValidInputStyle('passwordConfirmation');
  }
  
}