document.addEventListener("DOMContentLoaded", function () {

  //Scroll animacija do odredenih dijelova pocetne stranice (landing page)
  $('#mainNav a').click(function () {
    var divId = $(this).attr('href');
    $('html, body').animate({
      scrollTop: $(divId).offset().top - 56
    }, 800);
    $('.navbar-collapse').collapse('hide');
  });

})