
$(function ($) {
    "use strict";

jQuery(document).ready(function () {



	$(document).on('click', '.remove-img', function () {
		var id = $(this).find('input[type=hidden]').val();
        var rmvUrl = $(this).attr('data-href');
        if(rmvUrl){
            $.get(rmvUrl,function(res){
                $.notify(res.message,'success');
            })
        }
		$('#galval' + id).remove();
		$(this).parent().parent().remove();
	});

    $(document).on('click', '#prod_gallery', function () {
            $('#uploadgallery').click();
            $('#geniusform').find('.removegal').val(0);
        });


	$(document).on('change',"#uploadgallery",function () {
		var total_file = document.getElementById("uploadgallery").files.length;
		for (var i = 0; i < total_file; i++) {
			$('.selected-image .row').append('<div class="col-sm-6">' +
				'<div class="img gallery-img">' +
				'<span class="remove-img"><i class="fas fa-times"></i>' +
				'<input type="hidden" value="' + i + '">' +
				'</span>' +
				'<a href="' + URL.createObjectURL(event.target.files[i]) + '" target="_blank">' +
				'<img src="' + URL.createObjectURL(event.target.files[i]) + '" alt="gallery image">' +
				'</a>' +
				'</div>' +
				'</div> '
			);
			$('#geniusform').append('<input type="hidden" name="galval[]" id="galval' + i +
				'" class="removegal" value="' + i + '">')
		}

	});


  $(document).on('click', '#language-btn',function(){

      $("#language-section").append(
          `<div class="language-area  position-relative">
            <span class="remove-btn"><i class="fas fa-times"></i></span>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-6">
                    <div class="form-group ">
                        <textarea name="title[]" class="form-control" placeholder="Enter Title" required=""></textarea>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-6">
                    
                    <div class="form-group ">
                        <textarea name="content[]" class="form-control" placeholder="Enter Content" required=""></textarea>
                    </div>
                </div>
            </div>
        </div>`
);
  });
  
  $(document).on('click','.remove-btn', function(){
   $(this.parentNode).remove();
  });


  $('#tag').tagify();

    $(document).on('click','.term-check',function(){
        let id = $(this).attr('rel');
        if($(this).is(':checked')){
            $('#attrIdCheck'+id).attr('checked',true);
        }else{
            $('#attrIdCheck'+id).attr('checked',false);
        }
    })

    $(document).on('click','#extra-price',function(){
        if($(this).is(':checked')){
            $('.show-extra-price').removeClass('d-none');
        }else{
            $('.show-extra-price').addClass('d-none');
        }
    })

  
  // seo input form check
$(document).on('change','.seoCheck',function(){
  let checkVal = $(this).val();
  if(checkVal == 'yes'){
      $('.seo-show').removeClass('d-none');
  }else{
    $('.seo-show').addClass('d-none');
  }
})

$(document).ready(function(){
  let checkVal = $('.seoCheck').val();
  console.log(checkVal);
  if(checkVal == 'yes'){
      $('.seo-show').removeClass('d-none');
  }else{
    $('.seo-show').addClass('d-none');
  }
})
// seo input form check


$(document).on('click', "#price-btn",function(){

$("#price-section").append(
    `<div class="language-area  position-relative">
      <span class="price_remove-btn"><i class="fas fa-times"></i></span>
      <div class="row">
          <div class="col-sm-4 col-md-4 col-4">
              <div class="form-group ">
                  <input name="extra_price_name[]" class="form-control" placeholder="Enter Name" required=""/>
              </div>
          </div>
          <div class="col-sm-4 col-md-4 col-4">
              <div class="form-group ">
                <input type="number" name="extra_price[]" class="form-control" placeholder="Enter Price" required=""/>
              </div>
          </div>
          <div class="col-sm-4 col-md-4 col-4">
              <div class="form-group ">
                <select name="extra_price_type[]" class="form-control" required>
                    <option value="dey">Per Day</option>
                    <option value="month">Per Month</option>
                    <option value="year">Per Year</option>
                </select>
              </div>
          </div>
      </div>
  </div>`
);
});

$(document).on('click','.price_remove-btn', function(){
$(this.parentNode).remove();
});

$(document).on('click',"#faq-btn", function(){

$("#faq-section").append(
    `<div class="language-area  position-relative">
      <span class="remove-btn"><i class="fas fa-times"></i></span>
      <div class="row">
          <div class="col-sm-6 col-md-6 col-6">
              <div class="form-group ">
                  <input name="faq_title[]" class="form-control" placeholder="Enter Title" required="" />
              </div>
          </div>
          <div class="col-sm-6 col-md-6 col-6">
              <div class="form-group ">
                  <textarea name="faq_content[]" class="form-control" placeholder="Enter Content" required=""></textarea>
              </div>
          </div>
      </div>
  </div>`
);
});

$(document).on('click','.remove-btn', function(){
$(this.parentNode).remove();
});

$(document).on('change','.banner_image',function(){
    let invertoryImgTag =  $(this).parent().parent().parent().find('img');
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        
        $('.banner_image_view img').attr('src',e.target.result);
    };
    reader.readAsDataURL(file);
})

$(document).ready(function(){
        if($('#extra-price').is(':checked')){
            $('.show-extra-price').removeClass('d-none');
        }else{
            $('.show-extra-price').addClass('d-none');
        }
})


});
});