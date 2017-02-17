$( document ).ready(function() {
    $(".nav-opener").click(function () {
        $(".side-nav").toggleClass("nav-active");
    });
    $(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }

    });
    $('#toTop').click(function() {
        $('body,html').animate({scrollTop:0},800);
    });

});
