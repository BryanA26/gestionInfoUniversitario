


// Existe Jquery?
window.onload = function() {
  if (window.jQuery) {  
      // jQuery is loaded  

    //Preloader Jquery
    function Preloader() {
    // Animate loader off screen
    $(".loader").fadeOut("slow");
    $(".loader_container").fadeOut("slow");
    };

    Preloader();

  } else {
    // jQuery is not loaded

    // Preloader 
    function Preloader(){

      // Getting elements
      const loader = document.querySelector('.loader');
      const loaderContainer = document.querySelector('.loader_container');

      // Animate loader off screen
      loader.classList.toggle('loader-off');
      loaderContainer.classList.toggle('loader-off');

      setTimeout(() => {
        // Animate loader off screen ( post delay )
        loader.style.display = "none";
        loaderContainer.style.display = "none";
      }, 1000);

    }

    Preloader();
  }
}







