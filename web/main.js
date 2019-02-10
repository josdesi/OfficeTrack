
function validate ()
 {
  let userName = document.getElementById("username").value;
  let userNameRGEX = /^[a-zA-Z0-9\.]+g/
  let userNameResult = userNameRGEX.test(userName);
  alert("username:" + userNameResult);
};

// // function validate () {
// //   let password1 = document.getElementById("password").value;
// //   let passwordRGEX = /[\w.\S]{6,}/
// //   let password1Result = password1RGEX.test(password);
// //   alert("password:" + passwordResult);
// }
