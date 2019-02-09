
function validate () {
  let userName = document.getElementById("username").value;
  let userNameRGEX = /^[^\W\S\w]*$/
  let userNameResult = userNameRGEX.test(userName);
  alert("username:" + userNameResult);
}






// const inputs = document.querySelectorAll("input");
//
// const patterns = {
//   username:/^[(?:.)^\W\S\w]*$/
//   //password:/^[\S\W]{6,}$/
// };
//
// //verlos en funcionamiento en consola
//
// inputs.forEach((input) => {
//   input.addEventlistener("keyup", (e) => {
//     console.log
//   });
// });
