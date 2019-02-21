// -----------------------------

//   js index
/* =================== */
/*  -preloader
    -jQuery MeanMenu
    -meanmenu 
    -sticky
    -scroll-up
    -show-password
    -hide-show-sign-in-form
    -hide-show-reg-form
    -hide-show-search
    -counter
    -smooth scroll
    -countdown
    -off carousel
    -logo owl carousel
    -product single owl carousel
    -related-pro owl carousel
    -letest-video owl carousel
    -custome scrollTop Animate
    -pricing slider
    -handle counter activation
    -skills progress bar start
    -Ajax Contact Form

*/
// -----------------------------


(function($) {
    "use strict";



    /*---------------------
    preloader
    --------------------- */

    $(window).on('load', function() {
        $('#preloader').fadeOut('slow', function() { $(this).remove(); });
    });


    /*----------------------------
     jQuery MeanMenu
    ------------------------------ */
    $('nav#dropdown').meanmenu();

    /*-----------------
    meanmenu 
    -----------------*/
    $('nav#mobile_menu_active').meanmenu({
        meanScreenWidth: "991",
        meanMenuContainer: '.mobile-menu-area .container',
    });

    /*-----------------
    sticky
    -----------------*/
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 85) {
            $('.menu-area').addClass('navbar-fixed-top');
        } else {
            $('.menu-area').removeClass('navbar-fixed-top');
        }
    });

    /*-----------------
    scroll-up
    -----------------*/
    $.scrollUp({
        scrollText: '<i class="fa fa-arrow-up" aria-hidden="true"></i>',
        easingType: 'linear',
        scrollSpeed: 1500,
        animation: 'fade'
    });

    /*-----------------
    show-password
    -----------------*/
    $('.show-pass').on('click', function() {
        $('.type_password').attr('type', 'text');
    });


    /*-----------------------
    hide-show-sign-in-form
    -----------------------*/
    document.getElementById("sign_in_form").style.display = "none";
    $("#sign_in").on('click', function() {
        $("#sign_in_form").fadeToggle("slow");
    });


    /*-----------------------
    hide-show-reg-form
    -----------------------*/
    // document.getElementById("top_reg_form").style.display = "none";
    // $("#top_reg").on('click', function() {
    //     $("#top_reg_form").fadeToggle("slow");
    // });
    // $("#rfa_close").on('click', function() {
    //     $("#top_reg_form").fadeToggle("slow");
    // });


    /*-----------------------
    hide-show-search
    -----------------------*/
    document.getElementById("search_box").style.display = "none";
    $("#search_icon").on('click', function() {
        $("#search_box").fadeToggle("slow");
    });

    /*------------------------------
         counter
    ------------------------------ */
    $('.counter-up').counterUp();


    /*---------------------
    smooth scroll
    --------------------- */
    $('.smoothscroll').on('click', function(e) {
        e.preventDefault();
        var target = this.hash;
        $('html, body').stop().animate({
            'scrollTop': $(target).offset().top - 80
        }, 1200);
    });


    /*---------------------
    countdown
    --------------------- */
    $('[data-countdown]').each(function() {
        var $this = $(this),
            finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Min</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Sec</p></span>'));
        });
    });
	/*---------------------
     owl carousel
     --------------------- */
    $('#owl-demo1').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        smartSpeed: 800,
        navText: ["<i class='fa fa-long-arrow-left'></i>", "<i class='fa fa-long-arrow-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    /*---------------------
    off carousel
    --------------------- */
    $('.off-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: true,
        autoplay: false,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1
            },
            300: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
    });

    /*---------------------
    logo owl carousel
    --------------------- */
    $('#owl-demo2').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 6
                },
                1000: {
                    items: 6
                }
            }
        });
    /*---------------------
    product single owl carousel
    --------------------- */
    $('#demopro').owlCarousel({
            loop: true,
            nav: false,
            dots: true,
            autoplay: true,
            dotsEach: true,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    /*---------------------
    related-pro owl carousel
    --------------------- */
    $('#related-pro').owlCarousel({
            loop: true,
            nav: false,
            dots: true,
            autoplay: true,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
    /*---------------------
    letest-video owl carousel
    --------------------- */
    $('#letest-video').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dots: true,
        dotsEach: true,
        smartSpeed: 800,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    //    embded video popup
    $('.video').magnificPopup({
        type: 'iframe',
        iframe: {
            youtube: {
                index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

                id: 'v=', // String that splits URL in a two parts, second part should be %id%
                // Or null - full URL will be returned
                // Or a function that should return %id%, for example:
                // id: function(url) { return 'parsed id'; }

                src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
            }
        }


    });

    
    /*----------------------------
     custome scrollTop Animate
     ------------------------------*/
    $('.go-top').on('click', function(e) {
        var linkHref = $(this).attr('href');
        $('html,body').animate({
            scrollTop: $(linkHref).offset().top
        }, 1000);
        e.preventDefault();
    });


    $(".focus").focus(function() {
        $(this).parent().removeClass("unactive");
        $(this).parent().addClass("active");

    }).blur(function() {
        $(this).parent().removeClass("active");
        $(this).parent().addClass("unactive");
    });

    //    pricing slider
    $('.nstSlider').nstSlider({
        "left_grip_selector": ".leftGrip",
        "right_grip_selector": ".rightGrip",
        "value_bar_selector": ".bar",
        "value_changed_callback": function(cause, leftValue, rightValue) {
            $(this).parent().find('.leftLabel').text(leftValue);
            $(this).parent().find('.rightLabel').text(rightValue);
        }
    });

    //    handle counter activation
    $(function($) {
        var options = {
            minimum: 1,
            maximize: 10,
            onChange: valChanged,
            onMinimum: function(e) {
                console.log('reached minimum: ' + e)
            },
            onMaximize: function(e) {
                console.log('reached maximize' + e)
            }
        };
        $('#handleCounter').handleCounter(options);
        $('#handleCounter2').handleCounter(options);
        $('#handleCounter3').handleCounter({ maximize: 100 });
    });

    function valChanged(d) {
        //      console.log(d)
    }

    // //    skills progress bar start
    $('.experiences-section').waypoint(function() {
        $('.progress-bar').addClass('left-anim');
    }, {
        triggerOnce: true,
        offset: '50%'
    });


    /*---------------------
     Ajax Contact Form
     --------------------- */
    $('.cf-msg').hide();
    $('form#cf button#submit').on('click', function() {
        var fname = $('#fname').val();
        var subject = $('#subject').val();
        var email = $('#email').val();
        var msg = $('#msg').val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!regex.test(email)) {
            alert('Please enter valid email');
            return false;
        }

        fname = $.trim(fname);
        subject = $.trim(subject);
        email = $.trim(email);
        msg = $.trim(msg);

        if (fname != '' && email != '' && msg != '') {
            var values = "fname=" + fname + "&subject=" + subject + "&email=" + email + " &msg=" + msg;
            $.ajax({
                type: "POST",
                url: "mail.php",
                data: values,
                success: function() {
                    $('#fname').val('');
                    $('#subject').val('');
                    $('#email').val('');
                    $('#msg').val('');

                    $('.cf-msg').fadeIn().html('<div class="alert alert-success"><strong>Success!</strong> Email has been sent successfully.</div>');
                    setTimeout(function() {
                        $('.cf-msg').fadeOut('slow');
                    }, 4000);
                }
            });
        } else {
            $('.cf-msg').fadeIn().html('<div class="alert alert-danger"><strong>Warning!</strong> Please fillup the informations correctly.</div>')
        }
        return false;
    });



}(jQuery));


// var HomecompteARebour =  function(){
//     $('[data-countdown]').each(function() {
//         var $this = $(this),
//             finalDate = $(this).data('countdown');
//         $this.countdown(finalDate, function(event) {
//             $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Min</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Sec</p></span>'));
//         });
//     });
// };
var HomecompteARebour =  function(date){
    $('[data-countdown]').each(function() {
        var $this = $(this),
            finalDate = date;
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Jours</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Heures</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Minutes</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Secondes</p></span>'));
        });
    });
};

var HomeCarousel= function () {
    $('.off-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: true,
        autoplay: false,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1
            },
            300: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
    });
};

var AboutUSCarouBrand =function () {
    $('#owl-demo2').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: false,
        smartSpeed: 800,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 6
            },
            1000: {
                items: 6
            }
        }
    });
};


var blogVideoCarousel = function () {
    $('#letest-video').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dots: true,
        dotsEach: true,
        smartSpeed: 800,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    });
};