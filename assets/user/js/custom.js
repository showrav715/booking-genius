(function ($) {
	"use strict";

	$(document).ready(function () {

		// Drop Down Section

		$('.dropdown-toggle-1').on('click', function () {
			$(this).parent().siblings().find('.dropdown-menu').hide();
			$(this).next('.dropdown-menu').toggle();
		});

		$(document).on('click', function (e) {
			var container = $(".dropdown-toggle-1");
			// if the target of the click isn't the container nor a descendant of the container
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				container.next('.dropdown-menu').hide();
			}
		});

	});

	// Drop Down Section Ends 


// Footer Fixed js----------------//
$(document).ready(function() {
	var mainheight = parseInt($(window).height());
	var docHeight = parseInt($('.container-fluid').height());
	console.log(docHeight,mainheight);
	var isvalue = $('#isValue').val();
	$('.sticky-footer').addClass('fixed-bottom');
   if( docHeight > mainheight  && isvalue == null){
		$('.sticky-footer').removeClass('fixed-bottom');
   }
   
	});

// Footer Fixed js----------------//

})(jQuery);