//save elements in variables
let sidenav = document.getElementById("sidenav");
let bars = document.getElementById("bars");
let close = document.getElementById("close");


//sidenav toggler start
function openNav(event) {
    //scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
    //toggle icon and sidebar
    sidenav.classList.toggle("hidden");
    bars.classList.toggle("hidden");
    close.classList.toggle("hidden");
    
  }

//hide messages if user is created directly after updating one
  onappear.onchange(getMessages.classList.toggle("hidden"));

