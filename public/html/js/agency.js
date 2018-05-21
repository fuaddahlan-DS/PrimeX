// Agency Theme JavaScript

(function($) {
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function(){ 
            $('.navbar-toggle:visible').click();
    });

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 250
        }
    })
    
    if ($(window).width() <= 767) {
       $('#vertical-menu').hide();
    }else {
        $('#horizontal-menu').hide();
        
        $(window).scroll(function() {
            if ($(document).scrollTop() < 250) {
              $('#horizontal-menu').hide();
              $('#vertical-menu').show();
            } else {
              $('#horizontal-menu').show();
              $('#vertical-menu').hide();
            } 
        }); 
    }

})(jQuery); // End of use strict
