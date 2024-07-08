$(window).bind('scroll', function() {
    if ($(window).scrollTop() > 40) {
        $('.navbar-main').addClass('fixed-menu');
        $('.navbar-main').addClass('shadow');
        $('.navbar-main').addClass('scrolled');
        $('.mt-87').addClass('d-block');
        // $('.top').addClass('d-none');
        $('.top').addClass('scrolled');
        // $('.scroll').addClass('d-block');
        $('.scroll').addClass('scrolled');
        $('.navbar-brand').removeClass('shadow');
    } else {
        $('.navbar-main').removeClass('fixed-menu');
        $('.navbar-main').removeClass('shadow');
        $('.navbar-main').removeClass('scrolled');
        $('.mt-87').removeClass('d-block');
        // $('.top').removeClass('d-none');
        // $('.scroll').removeClass('d-block');
        $('.top').removeClass('scrolled');
        $('.scroll').removeClass('scrolled');
        $('.top .navbar-brand').addClass('shadow');
    }
});

function showTabMenu(e) {
    e.preventDefault();
    $('.sidebar').slideToggle();
}

function openNavbarSecond() {
    $('.navbar-second').slideToggle(300);
}

function closeNavbarSecond() {
    $('.navbar-second').slideUp(300);
}