jQuery(document).ready(function($){

	// Equal Heights plugin
	// By: Justin Hedani
	// Based on a plugin by: Scott Jehl
	$.fn.equalHeights = function() {
		$(this).each(function(){
			$(this).find('.module-title').css({'height': 'auto'});
			var currentTallestOne = 0;
			$(this).find('.module-title').each(function(i){
				if ($(this).height() > currentTallestOne) { currentTallestOne = $(this).height(); }
			});
			$(this).find('.module-title').css({'height': currentTallestOne});
		});

		$(this).each(function(){
			$(this).find('.module-content').css({'height': 'auto'});
			var currentTallestTwo = 0;
			$(this).find('.module-content').each(function(i){
				if ($(this).height() > currentTallestTwo) { currentTallestTwo = $(this).height(); }
			});
			$(this).find('.module-content').css({'height': currentTallestTwo});
		});

		$(this).each(function(){
			$(this).find('li.module').css({'height': 'auto'});
			var currentTallestThree = 0;
			$(this).find('li.module').each(function(i){
				if ($(this).height() > currentTallestThree) { currentTallestThree = $(this).height(); }
			});
			$(this).find('li.module').css({'height': currentTallestThree});
		});
		return this;
	};
	
	// Make it so that the heights of the Single Module layouts all have equal heights
	var windowWidth = $(window).width();
	$(window).bind("load", function(){
		if ($('body').hasClass('home')) {
			if ($('body').hasClass('modules-lessons') && $('body').hasClass('single-layout'))
				$('body.modules-lessons.single-layout #main ol#singularModulesLessons').equalHeights();
			
			if ($('body').hasClass('units-modules-lessons'))
				$('body.units-modules-lessons #main ol#unitsModulesLessons ol.modules').equalHeights();

			// Use delay to help prevent crazy javascript firing on resize
			// http://pastie.org/pastes/5100802/text
			var delay = (function(){
		  	var timer = 0;
		  	return function(callback, ms){
		  		clearTimeout (timer);
		    	timer = setTimeout(callback, ms);
		   	};
			})();

			$(function() {
		    var pause = 350; // will only process code within delay(function() { ... }) every 350ms.
		    $(window).resize(function() {
		      delay(function() {
		      	var windowWidth = $(window).width();
		      	//if (windowWidth > '767') {
							if ($('body').hasClass('modules-lessons') && $('body').hasClass('single-layout'))
								$('body.modules-lessons.single-layout #main ol#singularModulesLessons').equalHeights();
			
							if ($('body').hasClass('units-modules-lessons'))
								$('body.units-modules-lessons #main ol#unitsModulesLessons ol.modules').equalHeights();
		      	//}
		      }, pause );
		  	});
		    $(window).resize();
			});
		} // end if is_home
	});

	// Scroll To Top of Page
	$('#backToTop').click(function(){
		$('body').animate({ scrollTop: 0 }, 'fast' );
	});

	//	# UI Scripts #
	//	Hide/Show Edit Link for...
	if ($('body').hasClass('home') && $('body').hasClass('logged-in')) {
		$('.intro-banner').bind('mouseenter mouseleave', function(){ $(this).find('a.edit-post-link').toggle(); }); // Home Page
		$('li.module').bind('mouseenter mouseleave', function(){ $(this).find('a.edit-post-link').not('li.lesson a.edit-post-link').toggle(); }); // Modules
		$('li.lesson').bind('mouseenter mouseleave', function(){
			$(this).find('a.edit-post-link').toggle(); // Lessons
			$(this).closest('li.module').find('div.module-content-wrapper + a.edit-post-link').toggle(); // Hide Module edit when over a lesson
		});
	}
});