(function ($) {
	"use strict";

	$(document).ready(function () {

		
		$('.cp').colorpicker();
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


	// 2 select 
	$(document).ready(function() {
		$('.select2').select2();
	});
	// 2 select 


// Footer Fixed js----------------//
$(document).ready(function() {
	var mainheight = parseInt($(window).height());
	var docHeight = parseInt($('.container-fluid').height());
	var isvalue = $('#isValue').val();
	var isvalue = 1;
   if( docHeight < mainheight  && isvalue == null){
	 $('.sticky-footer').addClass('fixed-bottom');
   }
   
	});

// Footer Fixed js----------------//

	
	
$('#meta_tag').tagify();
$('#customCheck1').on('click',function(){
	if($('#customCheck1').prop('checked') == true){
		$('.meta_description').removeClass('d-none');
		
	}else{
		$('.meta_description').addClass('d-none');
	}
})
	
$('#meta_keys').tagify();
	
})(jQuery);