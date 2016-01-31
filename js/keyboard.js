$(document).ready(function () {
    // Keyboard Functionality
    $(window).keydown(function(e) {
        key = (e.keyCode) ? e.keyCode : e.which;
        $('.key.k' + key).addClass('active');
        //@TODO Add Functionality for input
        console.log(key);
    });

    $(window).keyup(function(e) {
        key = (e.keyCode) ? e.keyCode : e.which;
        $('.key.k' + key).removeClass('active');
    });

});
