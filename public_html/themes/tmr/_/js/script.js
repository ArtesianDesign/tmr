var slideshow_options = {
	auto: true, // Boolean: Animate automatically, true or false
	speed: 800, // Integer: Speed of the transition, in milliseconds
	timeout: 7000, // Integer: Time between slide transitions, in milliseconds
	pager: true, // Boolean: Show pager, true or false
	nav: true, // Boolean: Show navigation, true or false
	random: false, // Boolean: Randomize the order of the slides, true or false
	pause: true, // Boolean: Pause on hover, true or false
	pauseControls: true, // Boolean: Pause when hovering controls, true or false
	prevText: '&laquo;', // String: Text for the "previous" button
	nextText: '&raquo;', // String: Text for the "next" button
	maxwidth: '', // Integer: Max-width of the slideshow, in pixels
	controls: '.slides-nav', // Selector: Where controls should be appended to, default is after the 'ul'
	namespace: 'rslides', // String: change the default namespace used
	before: function(){}, // Function: Before callback
	after: function(){} // Function: After callback
};

var TMR = TMR || {};
TMR.loader = {
	ele: function(){
		if ($('#loading-indicator').length) return $('#loading-indicator');
		return $('<div id="loading-indicator" />').appendTo($('body'));
	},
	show: function(){
		this.ele().stop().fadeIn();
	},
	hide: function(){
		this.ele().stop().fadeOut();
	}
};

function maxLength (e) {    
    if (!document.createElement('textarea').maxLength) {
        var max = e.attributes.maxLength.value;
        e.onkeypress = function () {
            if(this.value.length >= max) return false;
        };
    }
}

$(function(){

	/**
	 * Heading slide show
	 * initialized only if there are more than one images found in the fileset
	 */
	$('.slides').each(function(){
		var $ss = $(this);
		if ($ss.find('.slide').length > 1) {

			// load custom settings
			var token = $ss.data('token');

			// allow the block settings to override defaults
			var options = $.extend({}, slideshow_options, $ss.data());
		
			// fire it off
			$ss.responsiveSlides(options);

			// if we have links, fancybox it
			if ($ss.find('a').length) {
				$ss.find('a[rel="slide-' + token + '"]').fancybox({
					openEffect: 'fade',
					prevEffect: 'fade',
					nextEffect: 'fade',
					helpers : {
						title: {
							type: 'inside'
						}
					}
				});
			}
		}
	});

	/**
	 * Capture Modal links
	 */
	$('a.modal').click(function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		TMR.loader.show();
		$.get(href, { ajax: true }, function(html){
			TMR.loader.hide();
			var $modal = $('<div class="reveal-modal"/>').html(html+'<a class="close-reveal-modal">×</a>').appendTo($('body'));
			$modal.reveal();
		});
	});
	
});