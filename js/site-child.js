(function($) {
	$(document).ready(function(){
        // Add helper classes wpbf-hidden-medium & wpbf-hidden-small to pre-header
        $('#pre-header').addClass( "wpbf-hidden-medium wpbf-hidden-small" );

		// Init Front Page Slider
		$('.front-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		arrows: true,
		infinite: true,
		speed: 500,
		autoplay: true,
		autoplaySpeed: 5000,
		adaptiveHeight: true,
		});
	    $('.front-haeuser-slider').slick({
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    dots: false,
	    arrows: true,
	    infinite: true,
	    speed: 500,
	    adaptiveHeight: true,
	    });

		// Init Haueser Slider
		$('.haeuser-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		adaptiveHeight: true,
		asNavFor: '.slider-nav'
		});
		// Init Haueser Slider Nav
		$('.slider-nav').slick({
		slidesToShow: 8,
		slidesToScroll: 1,
		asNavFor: '.haeuser-slider',
		dots: false,
		arrows: true,
		centerMode: true,
		focusOnSelect: true,
	    responsive: [
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 3
	        }
	      }
	    ]
		});

		// Init Aktivitaet Slider
		$('.aktivitaet-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		adaptiveHeight: true,
		draggable: false,
		asNavFor: '.aktivitaet-slider-nav'
		});
		// Init Aktivitaet Slider Nav
		$('.aktivitaet-slider-nav').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.aktivitaet-slider',
		dots: false,
		arrows: false,
		centerMode: true,
		focusOnSelect: true,
		vertical: true,
	    responsive: [
	      {
	        breakpoint: 480,
	        settings: {
	          vertical: false
	        }
	      }
	    ]
		});

	});
	$('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({ scrollTop: target.offset().top -50 }, 500);
        return false;
      }
    }
  });
    


})( jQuery );

