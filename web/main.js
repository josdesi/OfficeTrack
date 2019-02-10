
function validate (){
  let userName = document.getElementById("username").value;
  let password1 = document.getElementById("password").value;
  let userNameRGEX = /^[A-Z a-z 0-9\.]\S+[^`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]$/;
  let let password1RGEX = /^[\w\.]\S{6,}$/;
  let userNameResult = userNameRGEX.test(userName);
  let password1Result = password1RGEX.test(password);
  alert("username:"+userNameResult + ", password: "+password1Result );
};
