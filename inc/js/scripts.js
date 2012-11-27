jQuery(document).ready(function($){

	// Equal Heights plugin
	// By: Justin Hedani
	// Based on a plugin by: Scott Jehl
	$.fn.equalHeights = function() {
		$(this).each(function(){
			var currentTallestOne = 0;
			$(this).find('.module-title').each(function(i){
				if ($(this).height() > currentTallestOne) { currentTallestOne = $(this).height(); }
			});
			$(this).find('.module-title').css({'height': currentTallestOne}); // 20120130 - changed value to 'height'
		});

		$(this).each(function(){
			var currentTallestTwo = 0;
			$(this).find('.module-content').each(function(i){
				if ($(this).height() > currentTallestTwo) { currentTallestTwo = $(this).height(); }
			});
			$(this).find('.module-content').css({'height': currentTallestTwo}); // 20120130 - changed value to 'height'
		});
		return this;
	};
	
	// Make it so that the heights of the Single Module layouts all have equal heights
	if ($('body').hasClass('home')) {
		$('body.modules-lessons.single-layout #main ol#singularModulesLessons').equalHeights();
	}

	//	# UI Scripts #
	//	Hide/Show Edit Link for...
	if ($('body').hasClass('home') && $('body').hasClass('logged-in')) {
		$('#intro-banner').bind('mouseenter mouseleave', function(){ $(this).find('a.edit-post-link').toggle(); }); // Home Page
		$('li.module').bind('mouseenter mouseleave', function(){ $(this).find('a.edit-post-link').not('li.lesson a.edit-post-link').toggle(); }); // Modules
		$('li.lesson').bind('mouseenter mouseleave', function(){
			$(this).find('a.edit-post-link').toggle(); // Lessons
			$(this).closest('li.module').find('div.module-content-wrapper + a.edit-post-link').toggle(); // Hide Module edit when over a lesson
		});
	}
});