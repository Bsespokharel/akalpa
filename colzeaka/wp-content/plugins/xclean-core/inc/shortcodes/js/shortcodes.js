;(function($){
  $(document).ready(function($){
    /*==============================
    =            Toggle            =
    ==============================*/

    $('.et-toggle').addClass('inactive');
    $('.et-toggle>h4').click(function(){
      if ($(this).parent('.et-toggle').hasClass('active')) {
        $('.et-toggle').removeClass('active');
        $('.et-toggle').addClass('inactive');
        $(this).parent('.et-toggle.inactive').children('.toggle-content').slideUp().fadeOut(1000);
      } else {
        $('.et-toggle').removeClass('active');
        $('.et-toggle').addClass('inactive');
        $('.et-toggle.inactive>.toggle-content').slideUp().fadeOut(1000);
        $(this).parent('.et-toggle').removeClass('inactive');
        $(this).parent('.et-toggle').addClass('active');
        $(this).parent('.et-toggle.active').children('.toggle-content').slideDown().fadeIn(1000);
      }
    });
  });
})(jQuery);