
function tancaSessio(){
  clearCookie("email");
  document.location.href = './index.html';
}

function clearCookie(name){
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
}

function setCookie(name,value) {
    document.cookie = name + "=" + value + "; expires=Fri, 23 Dec 2022 12:00:00 UTC; path=/";
  }

function getCookie(cname) { /* As extracted from https://www.w3schools.com/js/js_cookies.asp */
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookiesIndex(){
  let email = getCookie("email");
  if (email != ""){
    /*Session is active, showing buttons*/
    document.getElementById("ident_b").style.visibility="hidden";
    document.getElementById("reserva_butt").style.visibility="visible";
    document.getElementById("admin_butt").style.visibility="visible";
    document.getElementById("sessio_butt").style.visibility="visible";
  }else {
    /*unregistered, hiding buttons*/
    document.getElementById("ident_b").style.visibility="visible";
    document.getElementById("reserva_butt").style.visibility="hidden";
    document.getElementById("admin_butt").style.visibility="hidden";
    document.getElementById("sessio_butt").style.visibility="hidden";
  }
}
function submitForm() {
    setCookie("email",document.getElementById("email").value);
    setCookie("password",document.getElementById("password").value);
    document.location.href = '../index.html';
}

checkCookiesIndex();