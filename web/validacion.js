
function validar() {

var p1 = document.getElementById('pswd');
var p2 = document.getElementById('pswd1');


  if (p1.value != p2.value) {
    p2.style.borderColor="red";
    p2.style.borderStyle="solid";
    p2.style.borderWidth="1.5";
    p2.style.backgroundColor="#FFEFF0";
    p2.setCustomValidity("Las contraseñas no coinciden");
    return false;
  } else {
    p2.style.borderColor="#9fcbe1";
    p2.style.borderStyle="solid";
    p2.style.borderWidth="1.5";
    p2.style.backgroundColor="#ecf5f9";
    p2.setCustomValidity("");
    return true; 
  }
}


function validate(id) {
  var elem = document.getElementById(id);

  if(elem.validity.patternMismatch){
     elem.setCustomValidity("Este campo no acepta carácteres especiales");
  }
  else{
    elem.setCustomValidity("");
  }
   }


   
   function val2() {
    var elem = document.getElementById('username');
    var icon = document.getElementById('basic-addon1');
  
    if(elem.validity.patternMismatch){
       elem.setCustomValidity("Este campo no acepta carácteres especiales");
       icon.style.borderColor="red";
       icon.style.borderStyle="solid";
       icon.style.borderWidth="5";
       icon.style.backgroundColor="#FFEFF0";
      
    }
    else{
      elem.setCustomValidity("");
      icon.style.borderColor="#9fcbe1";
      icon.style.borderStyle="solid";
      icon.style.borderWidth="5";
      icon.style.backgroundColor="#ecf5f9";
    }
     }

     function val1() {
      var elem = document.getElementById('pswd');
      var icon = document.getElementById('basic-addon2');
      
      if(elem.validity.patternMismatch){
         elem.setCustomValidity("Este campo no acepta carácteres especiales");
         icon.style.borderColor="red";
         icon.style.borderStyle="solid";
         icon.style.borderWidth="3";
         icon.style.backgroundColor="#FFEFF0";
         
      }
      else{
        elem.setCustomValidity("");
        icon.style.borderColor="#9fcbe1";
        icon.style.borderStyle="solid";
        icon.style.borderWidth="3";
        icon.style.backgroundColor="#ecf5f9";
      }
       }