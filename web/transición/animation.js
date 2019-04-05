var x = document.getElementById("anima");

x.addEventListener("animationend", myEndFunction());

function myEndFunction() {
    document.getElementById("anima").style.animationDuration = "5s";
  }