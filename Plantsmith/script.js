window.addEventListener("scroll", function() {
    var header = document.querySelector(".site-header");
    header.classList.toggle("scroll", window.scrollY > 0);
    var logo = document.getElementById('header-logo')
    if (window.scrollY == 0) {
      logo.src = "../images/logo/white-logotype-lockup.png";
    } else {
      logo.src = "../images/logo/black-logotype-lockup.png";
    }
  });
  


  
  