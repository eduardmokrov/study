/* ----------------- Start JS Document ----------------- */

var $ = jQuery.noConflict();

// Page Loader
$(window).load(function () {
    "use strict";
    $('#loader').fadeOut();
});

$(document).ready(function ($) {
    "use strict";


    /*----------------------------------------------------*/
    /*	Hidder Header
     /*----------------------------------------------------*/

    var headerEle = function () {
        var $headerHeight = $('header').height();
        $('.hidden-header').css({ 'height': 80 + "px" });
    };

    $(window).load(function () {
        headerEle();
    });

    $(window).resize(function () {
        headerEle();
    });

    /*----------------------------------------------------*/
    /*	Nice-Scroll
     /*----------------------------------------------------*/

    $("html").niceScroll({
        scrollspeed: 100,
        mousescrollstep: 38,
        cursorwidth: 5,
        cursorborder: 0,
        cursorcolor: '#333',
        autohidemode: true,
        zindex: 999999999,
        horizrailenabled: false,
        cursorborderradius: 0,
    });

    /*----------------------------------------------------*/
    /*	Nav Menu & Search
     /*----------------------------------------------------*/

    $(".nav > li:has(ul)").addClass("drop");
    $(".nav > li.drop > ul").addClass("dropdown");
    $(".nav > li.drop > ul.dropdown ul").addClass("sup-dropdown");

    $('.show-search').click(function () {
        $('.search-form').fadeIn(300);
        $('.search-form input').focus();
    });
    $('.search-form input').blur(function () {
        $('.search-form').fadeOut(300);
    });

    /*----------------------------------------------------*/
    /*	Back Top Link
     /*----------------------------------------------------*/

    var offset = 200;
    var duration = 500;
    $(window).scroll(function () {
        if ($(this).scrollTop() > offset) {
            $('.back-to-top').fadeIn(400);
        } else {
            $('.back-to-top').fadeOut(400);
        }
    });
    $('.back-to-top').click(function (event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    })

    /*----------------------------------------------------*/
    /*	Sliders & Carousel
     /*----------------------------------------------------*/

    ////------- Touch Slider
    var time = 4.4,
        $progressBar,
        $bar,
        $elem,
        isPause,
        tick,
        percentTime;
    $('.touch-slider').each(function () {
        var owl = jQuery(this),
            sliderNav = $(this).attr('data-slider-navigation'),
            sliderPag = $(this).attr('data-slider-pagination'),
            sliderProgressBar = $(this).attr('data-slider-progress-bar');

        if (sliderNav == 'false' || sliderNav == '0') {
            var returnSliderNav = false
        } else {
            var returnSliderNav = true
        }

        if (sliderPag == 'true' || sliderPag == '1') {
            var returnSliderPag = true
        } else {
            var returnSliderPag = false
        }

        if (sliderProgressBar == 'true' || sliderProgressBar == '1') {
            var returnSliderProgressBar = progressBar
            var returnAutoPlay = false
        } else {
            var returnSliderProgressBar = false
            var returnAutoPlay = true
        }

        owl.owlCarousel({
            navigation: returnSliderNav,
            pagination: returnSliderPag,
            slideSpeed: 400,
            paginationSpeed: 400,
            lazyLoad: true,
            singleItem: true,
            autoHeight: true,
            autoPlay: returnAutoPlay,
            stopOnHover: returnAutoPlay,
            transitionStyle: "fade",
            afterInit: returnSliderProgressBar,
            afterMove: moved,
            startDragging: pauseOnDragging
        });

    });

    function progressBar(elem) {
        $elem = elem;
        buildProgressBar();
        start();
    }

    function buildProgressBar() {
        $progressBar = $("<div>", {
            id: "progressBar"
        });
        $bar = $("<div>", {
            id: "bar"
        });
        $progressBar.append($bar).prependTo($elem);
    }

    function start() {
        percentTime = 0;
        isPause = false;
        tick = setInterval(interval, 10);
    };

    function interval() {
        if (isPause === false) {
            percentTime += 1 / time;

        }
    }

    function pauseOnDragging() {
        isPause = true;
    }

    function moved() {
        clearTimeout(tick);
        start();
    }


    /*----------------------------------------------------*/
    /*	Css3 Transition
     /*----------------------------------------------------*/

    $('*').each(function () {
        if ($(this).attr('data-animation')) {
            var $animationName = $(this).attr('data-animation'),
                $animationDelay = "delay-" + $(this).attr('data-animation-delay');
            $(this).appear(function () {
                $(this).addClass('animated').addClass($animationName);
                $(this).addClass('animated').addClass($animationDelay);
            });
        }
    });

    /*----------------------------------------------------*/
    /*	Nivo Lightbox
     /*----------------------------------------------------*/

    $('.lightbox').nivoLightbox({
        effect: 'fadeScale',
        keyboardNav: true,
        errorMessage: 'The requested content cannot be loaded. Please try again later.'
    });

    /*----------------------------------------------------*/
    /*	Change Slider Nav Icons
     /*----------------------------------------------------*/

    $('.touch-slider').find('.owl-prev').html('<i class="fa fa-angle-left"></i>');
    $('.touch-slider').find('.owl-next').html('<i class="fa fa-angle-right"></i>');

    $('.read-more').append('<i class="fa fa-angle-right"></i>');

    /*----------------------------------------------------*/
    /*	Tooltips & Fit Vids & Parallax & Text Animations
     /*----------------------------------------------------*/

    $('.itl-tooltip').tooltip();

    $('.bg-parallax').each(function () {
        $(this).parallax("30%", 0.2);
    });

    $('.tlt').textillate({
        loop: true,
        in: {
            effect: 'fadeInUp',
            delayScale: 2,
            delay: 50,
            sync: false,
            shuffle: false,
            reverse: true,
        },
        out: {
            effect: 'fadeOutUp',
            delayScale: 2,
            delay: 50,
            sync: false,
            shuffle: false,
            reverse: true,
        },
    });


    /*----------------------------------------------------*/
    /*	Sticky Header
     /*----------------------------------------------------*/

    (function () {

        var docElem = document.documentElement,
            didScroll = false,
            changeHeaderOn = 100;
        document.querySelector('header');

        function init() {
            window.addEventListener('scroll', function () {
                if (!didScroll) {
                    didScroll = true;
                    setTimeout(scrollPage, 250);
                }
            }, false);
        }

        function scrollPage() {
            var sy = scrollY();
            if (sy >= changeHeaderOn) {
                $('.top-bar').slideUp(300);
                $("header").addClass("fixed-header");
                $('.navbar-brand').css({ 'padding-top': 19 + "px", 'padding-bottom': 19 + "px" });

                if (/iPhone|iPod|BlackBerry/i.test(navigator.userAgent) || $(window).width() < 479) {
                    $('.navbar-default .navbar-nav > li > a').css({ 'padding-top': 0 + "px", 'padding-bottom': 0 + "px" })
                } else {
                    $('.navbar-default .navbar-nav > li > a').css({ 'padding-top': 20 + "px", 'padding-bottom': 20 + "px" })
                    $('.search-side').css({ 'margin-top': -7 + "px" });
                }
                ;

            }
            else {
                $('.top-bar').slideDown(300);
                $("header").removeClass("fixed-header");
                $('.navbar-brand').css({ 'padding-top': 27 + "px", 'padding-bottom': 27 + "px" });

                if (/iPhone|iPod|BlackBerry/i.test(navigator.userAgent) || $(window).width() < 479) {
                    $('.navbar-default .navbar-nav > li > a').css({ 'padding-top': 0 + "px", 'padding-bottom': 0 + "px" })
                } else {
                    $('.navbar-default .navbar-nav > li > a').css({ 'padding-top': 28 + "px", 'padding-bottom': 28 + "px" })
                    $('.search-side').css({ 'margin-top': 0 + "px" });
                }
                ;

            }
            didScroll = false;
        }

        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }

        init();


    })();

	/* Slick Nav */
	$('.wpb-mobile-menu').slicknav({
	  prependTo: '.abcd',
	  parentTag: 'matrix',
	  allowParentLinks: true,
	  duplicate: false,
	  label: '',
	  closedSymbol: '<i class="fa fa-angle-right"></i>',
	  openedSymbol: '<i class="fa fa-angle-down"></i>',
	});
	
});
/* ----------------- End JS Document ----------------- */
