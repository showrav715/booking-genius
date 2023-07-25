(function ($) {

      // ADD OPERATION
      
      $(document).on('click', '#add-data', function () {
        $('.submit-loader').show();
        $('#modal1').find('.modal-title').html(lang.new + ' ' + $('#headerdata').val());
        $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'), function (response, status, xhr) {
          if (status == "success")
            $('.submit-loader').hide();
        });
      });
  
      // ADD OPERATION END
  
      
    // EDIT OPERATION

    $(document).on('click', '.edit', function () {
       $('.submit-loader').show();
      $('#modal1').find('.modal-title').html(lang.edit + ' ' + $('#headerdata').val());
      $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'), function (response, status, xhr) {
        if (status == "success")
          $('.submit-loader').hide();
      });
    });
    
    $(document).on('click', '.details', function () {
       $('.submit-loader').show();
      $('#modal1').find('.modal-title').html(lang.details + ' ' + $('#headerdata').val());
      $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'), function (response, status, xhr) {
        if (status == "success")
          $('.submit-loader').hide();
      });
    });


    $(document).on('click', '.heighight', function () {
       $('.submit-loader').show();
      $('#modal1').find('.modal-title').html($('#headerdata').val());
      $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'), function (response, status, xhr) {
        if (status == "success")
          $('.submit-loader').hide();
      });
    });


    // EDIT OPERATION END

    // Delete Operation ------------------------------------------//

    $('#confirm-delete').on('show.bs.modal', function (e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });



    $('#confirm-delete .btn-ok').on('click', function (e) {
      if ($('#confirm-delete .btn-ok').hasClass("order-btn")) {
        if (admin_loader == 1) {
          $('.submit-loader').show();
        }
      }
      $.ajax({
        type: "GET",
        url: $(this).attr('href'),
        success: function (data) {
          $('#confirm-delete').modal('toggle');
          $('#geniustable').DataTable().ajax.reload();
          $('.alert-danger').hide();
          $('.alert-success').show();
          $('.alert-success p').html(data);
        }
      });
      return false;
    });


    // Delete Operation End ------------------------------------------//

  // LOGIN FORM

  $("#loginform").on('submit', function (e) {
    e.preventDefault();
    $('button.submit-btn').prop('disabled', true);
    $('.alert-info').show();
    $('.alert-info p').html($('#authdata').val());
    $.ajax({
      method: "POST",
      url: $(this).prop('action'),
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if ((data.errors)) {
          $('.alert-success').hide();
          $('.alert-info').hide();
          $('.alert-danger').show();
          $('.alert-danger ul').html('');
          for (var error in data.errors) {
            $('.alert-danger p').html(data.errors[error]);
          }
        } else {
          $('.alert-info').hide();
          $('.alert-danger').hide();
          $('.alert-success').show();
          $('.alert-success p').html(lang.sss);

          window.location = data;
        }
        $('button.submit-btn').prop('disabled', false);
      }

    });

  });


  // LOGIN FORM ENDS

// Modal Form Submit

  $(document).on('submit', '#ModalFormSubmit', function (e) {
    e.preventDefault();

    if(nicEditors.findEditor('area1')){
      nicEditors.findEditor('area1').saveContent();
    };
    
    if (admin_loader == 1) {
      $('.submit-loader').show();
    }
    var $this = $(this).parent();
    $('button.addProductSubmit-btn').prop('disabled', true);
    $.ajax({
      method: "POST",
      url: $(this).prop('action'),
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if ((data.errors)) {
          $this.find('.alert-danger').show();
          $this.find('.alert-danger ul').html('');
          for (var error in data.errors) {
            $this.find('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
          }
          if (admin_loader == 1) {
            $('.submit-loader').hide();
          }


          $("#modal1 .modal-content .modal-body .alert-danger").focus();
          $('button.addProductSubmit-btn').prop('disabled', false);
          $('#geniusformdata input , #geniusformdata select , #geniusformdata textarea').eq(1).focus();
        } else {
          $('#geniustable').DataTable().ajax.reload();
          $('.alert-success').show();
          $('.alert-success p').html(data);
          if (admin_loader == 1) {
            $('.submit-loader').hide();
          }
          $('button.addProductSubmit-btn').prop('disabled', false);
          $('#modal1,#modal2').modal('toggle');

        }
      }

    });

  });

  // Modal Form Submit

  var loading = `<span class="spinner-grow spinner-grow-sm"  role="status"></span> ${lang.loading}`;
  // ------------------------- Single Page Form JS Start ------------------------------------//
  $(document).on('submit', '#pageForm', function (e) {
    e.preventDefault();
    var geniusform = $(this);
    if (admin_loader == 1) {
      $('.loader').show();
    }
    var $this = $(this).parent();
    $.ajax({
      method: "POST",
      url: $(this).prop('action'),
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#insertButton').html(loading).prop('disabled', true);;
    },
    success: function(data) {
        $('#insertButton').html(lang.submit).prop('disabled', false);
        if ((data.errors)) {
          $('.loader').hide();
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in data.errors) {
                $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
            }
            $('body, html').animate({
                scrollTop: $('html').offset().top
            }, 'slow');
            
        } else {
          $('.loader').hide();
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data);
            $('body, html').animate({
                scrollTop: $('html').offset().top
            }, 'slow');
        }

    }

    });

  });

  $(document).on('submit', '#pageFormTable', function (e) {
    e.preventDefault();

    if (admin_loader == 1) {
      $('.loader').show();
    }

    $.ajax({
      method: "POST",
      url: $(this).prop('action'),
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#insertButton').html(loading).prop('disabled', true);;
    },
    success: function(data) {
        $('#insertButton').html('Submit').prop('disabled', false);
        if ((data.errors)) {
          $('.loader').hide();
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in data.errors) {
                $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
            }
            $('body, html').animate({
                scrollTop: $('html').offset().top
            }, 'slow');
            
        } else {
          $('.loader').hide();
          $('#geniustable').DataTable().ajax.reload();
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data);
            $('body, html').animate({
                scrollTop: $('html').offset().top
            }, 'slow');
        }

    }

    });

  });
  // ------------------------- Single Page Form JS End ------------------------------------//



  // Status Changing-------------------------------------------//

     // Droplinks Start
     $(document).on('click', '.StatusCheck', function () {
      var link = $(this).attr('data-href');
      $.get( link, function(data) {
        $('#geniustable').DataTable().ajax.reload();
        $('.alert-success').show();
        $('.alert-success p').html(data);
      });
     });
  
  
  


     // Droplinks Start
     $(document).on('click', '.social-status-check', function () {
      var link = $(this).attr('data-href');
      var status  = $(this).parent().prev();

      



      $.get(link, function(data) {
        if(data.data == 1){
          status.html(lang.active).addClass('btn-success').removeClass('btn-danger');
        }else{
          status.html(lang.deactive).addClass('btn-danger').removeClass('btn-success');
        }
        $('.alert-success').show();
        $('.alert-success p').html(data.mgs);
      });
    });


    // Single Page Status Check ------------------------//

    $(document).on('click', '.gs-status-check', function () {
     var status  = $(this).parent().prev();
     var validation  = $(this).parent().parent().prev();
  

      var link = $(this).attr('data-href');
      $.get( link, function(data) {
        if(data.status == 1){
              status.html(lang.active).addClass('btn-success').removeClass('btn-danger');
        }else{
          status.html(lang.deactive).addClass('btn-danger').removeClass('btn-success');
        }
        
        if(validation.html()){
          validation.find('.alert-danger').hide();
          validation.find('.alert-success').show();
          validation.find('.alert-success p').html(data.success);
        }else{
        $('.alert-danger').hide();
        $('.alert-success').show();
        $('.alert-success p').html(data.success);
        }
   
     
      });
    });

    // Move Upload JS Start---------------------------------------------------------//

    $(document).on('change','#video', function(){ 
      var formdata = new FormData(document.getElementById('form'));
        formdata.append('video_name', $(this));
      $.ajax({
            url: $(this).attr('data-href'),
            type: 'post',
            data: formdata,
            xhr: function() {
                var appXhr = $.ajaxSettings.xhr();
                if (appXhr.upload) {
                    if ('#video') {
                        appXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                currentMainProgress = (e.loaded / e.total) * 100;
                                currentMainProgress = parseInt(currentMainProgress);
                                $(".progress").removeClass('d-none');
                                $(".progress-bar").html(currentMainProgress + '%');
                                $(".progress-bar").width(currentMainProgress + '%');
                                if (currentMainProgress == 100)
                                    console.log('Progress : 100%');
                            }
                        }, false);
                    }
                  }
                   
                return appXhr;
            },
            success: function(data) {
             
              if ((data.errors)) {
              $(".progress").addClass('d-none');
              $('.alert-danger').show();
              $('.alert-danger ul').html('');
              for (var error in data.errors) {
               $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
            }
            $('body, html').animate({scrollTop:$('html').offset().top}, 'slow');
           
          }else{
           
            $('.image-area').removeClass('offset-md-6');
              $(".progress").addClass('d-none');
              $('.video-area').removeClass('d-none');
              $('#is_video').val(data);
              $('.video-area video').removeClass('d-none');
              $('.video-area video').attr('src',data);
              $('body, html').animate({scrollTop:$('html').offset().top}, 'slow');
              
          }
            },
           
            contentType: false,
            processData: false
    });
    
    });
  

      $('#video_image').on('change',function(){
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
          if($('#is_video').val() == '' &&  $('#previous_video').val() == ''){
            $('.image-area').removeClass('d-none').addClass('offset-md-6');
          }else{
            $('.image-area').removeClass('d-none');
          }
         
          $('.image-area img').attr('src',e.target.result);
         
        }
      
        reader.readAsDataURL(file);

      })

    // Move Upload JS End---------------------------------------------------------//


    //  Edit Image Upload -------------------------------//
    $('#edit_video_image').on('change',function(){
      var file = event.target.files[0];
      var reader = new FileReader();
      reader.onload = function(e) {
        $('.image-area img').attr('src',e.target.result);
      }
    
      reader.readAsDataURL(file);

    })
    //  Edit Image Upload -------------------------------//


    // All Image Reader -----------------------------//

    $('.image,#image').on('change',function(){
      var file = event.target.files[0];
      var reader = new FileReader();
      reader.onload = function(e) {
        // console.log(e.target.result)
        $('.ShowLanguageImage').removeClass('d-none');
        $('.ShowLanguageImage img').attr('src',e.target.result);
      };

      reader.readAsDataURL(file);
    })
  // All Image Reader -----------------------------//
  
  // Status Start
  $(document).on('click','.status',function () {
    var link = $(this).attr('data-href');
        $.get( link, function() {
          }).done(function(data) {
              $('#geniustable').DataTable().ajax.reload();
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success p').html(data);
        })
      });
// Status Ends


$(document).on('click', '#notf_conv', function () {
  $("#conv-notf-count").html('0');
  $('#conv-notf-show').load($("#conv-notf-show").data('href'));
});

$(document).on('click', '#conv-notf-clear', function () {
  $(this).parent().parent().trigger('click');
  $.get($('#conv-notf-clear').data('href'));
});

// CONVERSATION NOTIFICATION ENDS


// SEND MESSAGE SECTION
$(document).on('click', '.send', function () {
  $('.eml-val').val($(this).attr('data-href'));
});

$(document).on("submit", "#emailreply1", function () {
  var token = $(this).find('input[name=_token]').val();
  var subject = $(this).find('input[name=subject]').val();
  var message = $(this).find('textarea[name=message]').val();
  var to = $(this).find('input[name=to]').val();
  $.ajax({
    type: 'post',
    url: mainurl + '/admin/user/send/message',
    data: {
      '_token': token,
      'subject': subject,
      'message': message,
      'to': to
    },
    beforeSend: function () {
      $('#emailreply1 .spinner-grow').removeClass('d-none');
    },
    success: function (data) {
      document.getElementById('emailreply1').reset();
      if (data == 0)
        $.notify("Oops Something Goes Wrong !!", "error");
      else
      $('#geniustable').DataTable().ajax.reload();
        $.notify("Message Sent !!", "success");
        
      $('.close').click();
      $('#emailreply1 .spinner-grow').addClass('d-none');
    }
  });
  return false;
});

// SEND MESSAGE SECTION ENDS




 // MESSAGE FORM

 $(document).on('submit', '#messageform', function (e) {
  e.preventDefault();
  var href = $(this).data('href');
  $('.gocover').show();
  $('button.mybtn1').prop('disabled', true);
  $.ajax({
    method: "POST",
    url: $(this).prop('action'),
    data: new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      if ((data.errors)) {
        $('.alert-success').hide();
        $('.alert-danger').show();
        $('.alert-danger ul').html('');
        for (var error in data.errors) {
          $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>')
        }
        $('#messageform textarea').val('');
      } else {
        $('.alert-danger').hide();
        $('.alert-success').show();
        $('.alert-success p').html(data);
        $('#messageform textarea').val('');
        $('#messages').load(href);
      }
      $('.gocover').hide();
      $.notify(data,'success');
    }
  });
});

// MESSAGE FORM ENDS


$(document).on('click', '#notf_order a', function () {
  $('#order-notf-show').load($("#order-notf-show").data('href'));
});

$(document).on('click', '#order-notf-clear', function () {
  $(this).parent().parent().trigger('click');
  var url = $('#order-notf-clear').data('href');
  $.ajax({
    type: "GET",
    url: url,
    success: function (data) {
      $('#order-notf-show').html('');
    }
  });
});

// ORDER NOTIFICATION ENDS

// Location Js Start 
  $(document).on('change','#country',function(){
    let countryId = $(this).val();
    $.get(mainurl+'/location/state/ajax/'+countryId,function(res){
      if(res.data == 0){
        alert('State Not Found');
      }else{
      $('#state').html('');
      let stateData = '';
      res.data.map(function(val){
        stateData += `<option value="${val.id}">${val.state}</option>`;
      })
      console.log(res.data);
      $('#state').html(stateData);
    }
    })
  })


  $(document).ready(function () {
    let page_id = $('#page_id').val();
    if (page_id == 1) {
      let slectedCountry = $('#country').val();
      let updateLocationUrl = mainurl+'/location/state/update/'+slectedCountry;
      let updateStateId = $('#update_state_id').val();
      $.get(updateLocationUrl,function(res){
        let updatestateHtml = '';
        res.data.map(function(val){
            updatestateHtml +=   `<option value="${val.id}" ${updateStateId == val.id ? 'selected' : ''}> ${val.state} </option> `;
        });
        $('#state').html(updatestateHtml);
      })
  }
  
})

// Location Js End
  
  
$(document).on('change','.profile_image',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
      $('.profile_image_view img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})



// order details show js
$(document).on('click','.order_details',function(){
  $('.loader').show();
  let detailsUrl =  $(this).attr('href');
  
  $.get(detailsUrl,function(data){
    $('.loader').hide();
    $('#show_order').html(data);
  })
})
// order details show ,js

  
  // language js
  function isEmpty(el){
    return !$.trim(el.html())
}

$("#language-btn").on('click', function(){
  $("#language-section").append(
      `<div class="language-area  position-relative">
        <span class="remove-btn"><i class="fas fa-times"></i></span>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-6">
                <div class="form-group ">
                    <textarea name="keys[]" class="form-control" placeholder="Enter Language Key" required=""></textarea>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-6">
                
                <div class="form-group ">
                    <textarea name="values[]" class="form-control" placeholder="Enter Language Value" required=""></textarea>
                </div>
            </div>
        </div>
    </div>`
);
});

$(document).on('click','.remove-btn', function(){

$(this.parentNode).remove();
  if (isEmpty($('#language-section'))) {
  $("#language-section").append(
    ` <div class="language-area  position-relative">
        <span class="remove-btn"><i class="fas fa-times"></i></span>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-6">
                <div class="form-group ">
                    <textarea name="keys[]" class="form-control" placeholder="Enter Language Key" required=""></textarea>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-6">
                
                <div class="form-group ">
                    <textarea name="values[]" class="form-control" placeholder="Enter Language Value" required=""></textarea>
                </div>
            </div>
        </div>
    </div>`
   );
  }
});
  
  
  // meta tags js
  $('#tag').tagify();
  $('#meta_tag').tagify();

  $(document).on('click','#seo',function(){
      if($(this).is(':checked')){
         $('.showbox').removeClass('d-none');
          }else{
              $('.showbox').addClass('d-none');
          }
  });

  $(document).ready(function(){
      if($('#seo').is(':checked')){
         $('.showbox').removeClass('d-none');
          }else{
              $('.showbox').addClass('d-none');
          }
  });

// language js
  

// breadcum_banner
$('#breadcum_banner').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.image-view img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})
// breadcum_banner
  
// error-image

  
$('#error-image').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.image-view-error img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})

// error-image
// favicon

$('#favicon').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.image-view-favicon img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})  
  
//favicon
  
  
//website-loader
    
$('#website-loader').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.website-loader img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})

  $('#admin-loader').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.admin-loader img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
  })
  
//website-loader
  
//website-logo
$('#header-logo').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.image-view-header img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})

  $('#footer-logo').on('change',function(){
  var file = event.target.files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    $('.image-view-footer img').attr('src',e.target.result);
  };
  reader.readAsDataURL(file);
})
  //website-logo



  // bulk delete js
  
  $(document).on('change','.bulk-check',function(){   
    let checkValue = [];
    $(".bulk-check:checked").each(function () {
        checkValue.push($(this).val());
    });

   if(checkValue.length == 0){
    $('#all_select').prop('checked',false)
     $('#bulk-delete button').prop('disabled', true);
   } else {
    $('#bulk-delete button').prop('disabled', false);
   }
})


$(document).on('change','#all_select',function(){
    if(this.checked) {
        $(".bulk-check").each(function () {
          $(this).prop('checked', true);
          $('#bulk-delete button').prop('disabled', false);
        });
       
    }else{
        $(".bulk-check").each(function () {
          $(this).prop('checked', false);
          $('#bulk-delete button').prop('disabled', true);
        }); 
    }
});


  $(document).on('submit','#bulk-delete', function (e) {
    e.preventDefault();
    let ids = getIds()
    $('#getId').val(ids);

    $.ajax({
           type: "GET",
           url: $('#bulk-delete').attr('action'),
           data: $('#bulk-delete').serialize(),
           success: function(data)
           {
             
             if (data.status == 0) {
               $.notify(data.message);
             } else {
                $('#all_select').prop('checked', false);
                $.notify(data.message, 'success');
                $('#geniustable').DataTable().ajax.reload();
             }
           }
         });

  })
  // bulk delete js


  function getIds() {
    let getid = [];
    $(".bulk-check:checked").each(function () {
      getid.push($(this).val());
    });
    return getid;
  }



  //complete status check 

  $('#complete_check').on('show.bs.modal', function (e) {
    $(this).find('.status_btn').attr('href', $(e.relatedTarget).data('href'));
  });


  $(document).on('click', '.status_btn', function (e) {
    e.preventDefault();
    let pre = $(this).text();
    var send = `<span class="spinner-grow spinner-grow-sm"  role="status"></span> Sending Mail...`;
    $(this).html(send);
    var link = $(this).attr('href');
      $.get( link, function(data) {
        $('#geniustable').DataTable().ajax.reload();
        $('.alert-success').show();
        $('.alert-success p').html(data);
        $('#complete_check .close').click();
        $('.status_btn').text(pre);
      });

  })




})(jQuery);