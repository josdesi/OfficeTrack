
function validate (){
  var userName = document.getElementById("username").value;
  var password = document.getElementById("pswd").value;
  var userNameRGEX = /^[A-Z a-z 0-9\.]\S+[^`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]$/;
  var passwordRGEX = /^[A-Z a-z 0-9\S]{6,}$/;
  var userNameResult = userNameRGEX.test(userName);
  var passwordResult = passwordRGEX.test(password);
  alert("username:"+userNameResult + ", pswd: "+passwordResult);
  if (userName == false)
  {
    alert("Por favor ingresa un nombre de usuario valido");
    return false;
  }
  if(passwordResult == false)
  {
    alert("Por favor ingresa una contraseña valida");
    return false;
  }
  return true;
};
