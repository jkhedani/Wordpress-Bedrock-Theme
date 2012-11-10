jQuery(document).ready(function($){

	// Equal Heights plugin
	// By: Scott Jehl
	// Modified by: Justin Hedani
	$.fn.equalHeights = function(px) {
		$(this).each(function(){
			var currentTallest = 0;
			$(this).find('.module-title').each(function(i){
				if ($(this).height() > currentTallest) { currentTallest = $(this).height(); }
			});
			//if (!px || !Number.prototype.pxToEm) currentTallest = currentTallest.pxToEm(); //use ems unless px is specified
			// for ie6, set height since min-height isn't supported
			if ($.browser.msie && $.browser.version == 6.0) { $(this).find('.module-title').css({'height': currentTallest}); }
			$(this).find('.module-title').css({'height': currentTallest}); // 20120130 - changed value to 'height'
		});
		return this;
	};
	
	// Make it so that the heights of the Single Module layouts all have equal heights
	$('body.modules-lessons.single-layout #main ol.modules').equalHeights();
});