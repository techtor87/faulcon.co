jQuery(document).ready(function($) { 

	jQuery(".is-style-bbp-block-with-flexslider").flexslider({
		namespace: 'bbp-flexslider-',
		selector: ".wp-block-image",
		animation: "fade",
		animationLoop: true,
		initDelay: 500,
		smoothHeight: false,
		slideshow: false,
		slideshowSpeed: 0,
		pauseOnAction: true,
		pauseOnHover: false,
		controlNav: true,
		directionNav: true,
		useCSS: true,
		touch: true,
		animationSpeed: 500,
		allowOneSlide: false,
		rtl: false,
		reverse: false,
	    prevText: '<i class="fas fa-chevron-left"></i>',
	    nextText: '<i class="fas fa-chevron-right"></i>',
	    start: function(slider) { slider.addClass('bbp-block-flexslider-loaded'); }
	});

});