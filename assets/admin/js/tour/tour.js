
$(function ($) {
    "use strict";


    jQuery(document).ready(function () {


// ============= Gallery Section Insert Start ==================

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

// ============= Gallery Section Insert End ==================



$(document).on('click',"#language-btn", function(){

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

$(document).on('click',"#faq-btn", function(){

  $("#faq-section").append(
      `<div class="language-area  position-relative">
        <span class="remove-btn remove"><i class="fas fa-times"></i></span>
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


$(document).on('click',"#inventory-btn", function(){
    let randomnumber = Math.random();
  $("#inventory-section").append(
      `<div class="language-area position-relative">
        <span class="remove-btn remove"><i class="fas fa-times"></i></span>
        <div class="row border-buttom my-3">
            <div class="col-sm-3 col-md-3 col-3">
                    <img class="img-fluid inventory-image" width='80' height='80' src="${mainurl}../assets/images/placeholder.jpg" />
                    <div class="form-group">
            <div class="custom-file" >
                <input type="file" class="custom-file-input invertore_image new_invertory_file"  id="${randomnumber}"  name="inventory_image[]" required>
                <label class="bg-primary text-white btn btn-sm" for="${randomnumber}">Browser
                </label>
            </div>
        </div>
            </div>

            <div class="col-sm-4 col-md-4 col-4">
               <div class="row ">
                <div class="form-group ">
                    <input name="inventory_title[]" class="form-control" placeholder="Title: Day One" required="" />
                </div>
                <div class="form-group ">
                    <input name="inventory_desc[]" class="form-control" placeholder="Desc: TP. HCM City" required="" />
                </div>
               </div>
            </div>

            <div class="col-sm-5 col-md-5 col-5">
                <div class="form-group ">
                    <textarea name="inventory_content[]" class="form-control" placeholder="Enter Content" required=""></textarea>
                </div>
            </div>
        </div>
    </div>`
);
});

$(document).on('click','.remove-btn', function(){
$(this.parentNode).remove();
});


$(document).on('click',"#include-btn", function(){
  $("#include-section").append(
      `<div class="language-area  position-relative">
        <span class="remove-btn remove"><i class="fas fa-times"></i></span>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="form-group ">
                    <input name="include[]" class="form-control" value="" placeholder="Eg: Specialized bilingual guide" required="" />
                </div>
            </div>
        </div>
    </div>`
);
});

$(document).on('click','.remove-btn', function(){
$(this.parentNode).remove();
});


$(document).on('click',"#exclude-btn", function(){
  $("#exclude-section").append(
      `<div class="language-area position-relative">
        <span class="remove-btn remove"><i class="fas fa-times"></i></span>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-12">
                <div class="form-group ">
                    <input name="exclude[]" class="form-control" value="" placeholder="Eg: Specialized bilingual guide" required="" />
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

$(document).ready(function(){
    if($('#extra-price').is(':checked')){
        $('.show-extra-price').removeClass('d-none');
    }else{
        $('.show-extra-price').addClass('d-none');
    }
})
  



$(document).ready(function(){
    if($('.persion-check').is(':checked')){
        $('.persion-type').removeClass('d-none');
    }else{
        $('.persion-type').addClass('d-none');
    }
})

$(document).on('click','.persion-check',function(){
    if($(this).is(':checked')){
        $('.persion-type').removeClass('d-none');
    }else{
        $('.persion-type').addClass('d-none');
    }
})


$(document).on('click',"#price-btn", function(){

$("#price-section").append(
`<div class="language-area position-relative">
  <span class="price_remove-btn remove"><i class="fas fa-times"></i></span>
  <div class="row">
      <div class="col-sm-4 col-md-4 col-4">
          <div class="form-group ">
              <input name="extra_price_name[]" class="form-control" placeholder="Enter Name" required=""/>
          </div>
      </div>
      <div class="col-sm-4 col-md-4 col-4">
          <div class="form-group ">
            <input type="number" name="extra_price[]" step="0.1" class="form-control" placeholder="Enter Price" required=""/>
          </div>
      </div>
      <div class="col-sm-4 col-md-4 col-4">
          <div class="form-group ">
            <select name="extra_price_type[]" class="form-control" required>
                <option value="one time">One Time</option>
                <option value="per dey">Per Day</option>
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


$(document).on('click', "#persion-btn",function(){

$("#persion-section").append(
`<div class="language-area position-relative">
  <span class="price_remove-btn remove"><i class="fas fa-times"></i></span>
  <div class="row ">
      <div class="col-sm-3 col-md-3 col-3">
          <div class="form-group ">
              <input name="person_type[]" class="form-control" placeholder="Eg: Adults" required=""/>
          </div>
      </div>
      <div class="col-sm-3 col-md-3 col-3">
          <div class="form-group ">
            <input type="number" name="person_type_min[]" class="form-control" placeholder="Minimum" required=""/>
          </div>
      </div>
      <div class="col-sm-3 col-md-3 col-3">
        <div class="form-group ">
            <input type="number" name="person_type_max[]" class="form-control" placeholder="Maximum" required=""/>
          </div>
      </div>
      <div class="col-sm-3 col-md-3 col-3">
        <div class="form-group ">
            <input type="number" name="person_type_price[]" class="form-control" placeholder="Per 1 Item" required=""/>
          </div>
      </div>
  </div>
</div>`
);
});

$(document).on('click','.price_remove-btn', function(){
$(this.parentNode).remove();
});


$(document).on('change','.invertore_image',function(){

let invertoryImgTag =  $(this).parent().parent().parent().find('img');
var file = event.target.files[0];
var reader = new FileReader();
reader.onload = function(e) {
    invertoryImgTag.attr('src',e.target.result);
};
reader.readAsDataURL(file);
})

$(document).on('change','.banner_image',function(){
var file = event.target.files[0];
var reader = new FileReader();
reader.onload = function(e) {
    $('.banner_image_view img').attr('src',e.target.result);
};
reader.readAsDataURL(file);
})


$(document).on('change','.allreadyUpdate',function(){
var file = event.target.files[0];
var form = new FormData();
    form.append('image',file);

$.ajax({
        type: "post",
        url: $(this).attr('data-href'),
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        data: form,
          success: function(data)
       {
          $.notify(data.message,'success');
       },
        contentType: false,
        processData: false
     });
})

$(document).on('change','.new_invertory_file',function(){
var file = event.target.files[0];
var form = new FormData();
    form.append('image',file);
let thisTour = $('#isTourId').val();
$.ajax({

       type: "post",
       url: mainurl+'/admin/new-inventory/image/upload/ajax/'+thisTour,
       headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
       data: form,
       success: function(data)
       { 
        $.notify(data.message,'success');
        if(data.status == 1){
            location.reload();
        }
        
       },
       contentType: false,
        processData: false
     });

})

$(document).on('click','.inventory_remove',function(){
let tourIdRemove = $(this).attr('data-href');
$.get(mainurl+'/admin/inventore-remove/single/'+tourIdRemove,function(response){
    $.notify(response.message,'success');
    location.reload();
})
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
if(checkVal == 'yes'){
  $('.seo-show').removeClass('d-none');
}else{
$('.seo-show').addClass('d-none');
}
})
        
// seo input form check
    
});

});
