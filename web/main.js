
function validate (){
  var userName = document.getElementById("username").value;
  var password1 = document.getElementById("password").value;
  var userNameRGEX = /^[A-Z a-z 0-9\.]\S+[^`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]$/;
  var password1RGEX = /^[A-Z a-z 0-9\S]{6,}$/;
  var userNameResult = userNameRGEX.test(userName);
  var password1Result = password1RGEX.test(password);
  alert("username:"+userNameResult + ", password: "+password1Result);
};
