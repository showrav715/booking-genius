$(function () {
	"use strict";

	$(document).ready(function () {

  // All Image Reader -----------------------------//

  $('#image').on('change', function () {
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.ShowLanguageImage').removeClass('d-none');
      $('.ShowLanguageImage img').attr('src', e.target.result);
    };

    reader.readAsDataURL(file);
  })
  // All Image Reader -----------------------------//


  $(document).on('submit', '#ModalFormSubmit', function (e) {
    e.preventDefault();

    if(nicEditors.findEditor('area1')){
      nicEditors.findEditor('area1').saveContent();
    };
    
    if (website_loader == 1) {
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
          if (website_loader == 1) {
            $('.submit-loader').hide();
          }


          $("#modal1 .modal-content .modal-body .alert-danger").focus();
          $('button.addProductSubmit-btn').prop('disabled', false);
          $('#geniusformdata input , #geniusformdata select , #geniusformdata textarea').eq(1).focus();
        } else {
          $('#geniustable').DataTable().ajax.reload();
          $('.alert-success').show();
          $('.alert-success p').html(data);
          if (website_loader == 1) {
            $('.submit-loader').hide();
          }
          $('button.addProductSubmit-btn').prop('disabled', false);
          $('#modal1,#modal2').modal('toggle');

        }
      }

    });

  });

  // Delete Operation ------------------------------------------//

  $('#confirm-delete').on('show.bs.modal', function (e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
    
  $('#confirm-book-cancel').on('show.bs.modal', function (e) {
    $(this).find('input#order_id').val($(e.relatedTarget).data('href'));
  });


  $('.refresh_code').on("click", function () {
    $.get($(this).data('href'), function (data, status) {
      $('.codeimg1').attr("src", "" + mainurl + "/assets/images/capcha_code.png?time=" + Math.random());
    });
  })




  $('#confirm-delete .btn-ok').on('click', function (e) {
    if ($('#confirm-delete .btn-ok').hasClass("order-btn")) {
      if (website_loader == 1) {
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

  // Droplinks Start
  $(document).on('click', '.StatusCheck', function () {
    var link = $(this).attr('data-href');
    $.get(link, function (data) {
      $('#geniustable').DataTable().ajax.reload();
      $('.alert-success').show();
      $('.alert-success p').html(data);
    });
  });


  // FORGOT FORM

  $("#forgotform").on('submit', function (e) {
    e.preventDefault();
    $('button.submit-btn').prop('disabled', true);
    $('.alert-info').show();
    $('.alert-info p').html($('.authdata').val());
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
          $('.alert-success p').html(data);
          $('input[type=email]').val('');
        }
        $('button.submit-btn').prop('disabled', false);
      }
    });

  });

  //  FORGOT FORM ENDS




  // ******************************** LOGIN JS  ****************************************//
  // LOGIN FORM

  $("#loginform").on('submit', function (e) {
    e.preventDefault();
    $('#loginform button.submit-btn').prop('disabled', true);
    $('#loginform .alert-info').show();
    $('#loginform .alert-info p').html($('#authdata').val());
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
          $('#loginform .alert-success').hide();
          $('#loginform .alert-info').hide();
          $('#loginform .alert-danger').show();
          $('#loginform .alert-danger ul').html('');
          for (var error in data.errors) {
            $('#loginform .alert-danger p').html(data.errors[error]);
          }
        } else {
          $('#loginform .alert-info').hide();
          $('#loginform .alert-danger').hide();
          $('#loginform .alert-success').show();
          $('#loginform .alert-success p').html(lang.sss);
          window.location = data;
        }
        $('#loginform button.submit-btn').prop('disabled', false);
      }
    });

  });

  // LOGIN FORM ENDS


  // REGISTER FORM
  $("#registerform").on('submit', function (e) {
    var $this = $(this).parent();
    e.preventDefault();
    $this.find('button.submit-btn').prop('disabled', true);
    $this.find('.alert-info').show();
    $this.find('.alert-info p').html(lang.processing);
    $.ajax({
      method: "POST",
      url: $(this).prop('action'),
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        console.log(data);
        if (data.status == 1) {
          location.href = mainurl+'/user/dashboard';
        } else {

          if ((data.errors)) {
            $this.find('.alert-success').hide();
            $this.find('.alert-info').hide();
            $this.find('.alert-danger').show();
            $this.find('.alert-danger ul').html('');
            for (var error in data.errors) {
              $this.find('.alert-danger p').html(data.errors[error]);
            }
            $this.find('button.submit-btn').prop('disabled', false);
          } else {
            $this.find('.alert-info').hide();
            $this.find('.alert-danger').hide();
            $this.find('.alert-success').show();
            $this.find('.alert-success p').html(data);
            $this.find('button.submit-btn').prop('disabled', false);
          }

        }
        $('.refresh_code').click();

      }

    });

  });
  // REGISTER FORM ENDS





  // Single Page Form submit -----------------------------//
  var loading = `<span class="spinner-grow spinner-grow-sm"  role="status"></span> Please wait Data Processing...`;
  // ------------------------- Single Page Form JS Start ------------------------------------//
  $(document).on('submit', '#pageForm', function (e) {
    e.preventDefault();
    var geniusform = $(this);
    if (website_loader == 1) {
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
      beforeSend: function () {
        $('#insertButton').html(loading).prop('disabled', true);;
      },
      success: function (data) {
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

  // Single Page Form submit -----------------------------//


  // Location Js Start 
  $(document).on('change', '#country', function () {
    let countryId = $(this).val();
    $.get(mainurl + '/location/state/ajax/' + countryId, function (res) {
      if (res.data == 0) {
        alert('State Not Found');
      } else {
        $('#state').html('');
        let stateData = '';
        res.data.map(function (val) {
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
      let updateLocationUrl = mainurl + '/location/state/update/' + slectedCountry;
      let updateStateId = $('#update_state_id').val();
      $.get(updateLocationUrl, function (res) {
        let updatestateHtml = '';
        res.data.map(function (val) {
          updatestateHtml += `<option value="${val.id}" ${updateStateId == val.id ? 'selected' : ''}> ${val.state} </option> `;
        });
        $('#state').html(updatestateHtml);
      })
    }

  })


  // Location Js End


  $(document).on('click', '#notf_order a', function () {
    $('#order-notf-show').load($("#order-notf-show").data('href'));
  });

  $(document).on('click', '#order-notf-clear', function () {
    $(this).parent().parent().trigger('click');
    var url = $('#order-notf-clear').data('href');
    $.ajax({
      type: "GET",
      url: url,
      success: function (data) { }
    });
  });

  // ORDER NOTIFICATION ENDS



  // order details show js
  $(document).on('click', '.order_details', function () {
    $('.loader').show();
    let detailsUrl = $(this).attr('href');
  
    $.get(detailsUrl, function (data) {
      $('.loader').hide();
      $('#show_order').html(data);
    })
  })
  // order details show ,js



  // bulk delete js
  
  $(document).on('change', '.bulk-check', function () {
    let checkValue = [];
    $(".bulk-check:checked").each(function () {
      checkValue.push($(this).val());
    });

    if (checkValue.length == 0) {
      $('#all_select').prop('checked', false)
      $('#bulk-delete button').prop('disabled', true);
    } else {
      $('#bulk-delete button').prop('disabled', false);
    }
  })


  $(document).on('change', '#all_select', function () {
    if (this.checked) {
      $(".bulk-check").each(function () {
        $(this).prop('checked', true);
        $('#bulk-delete button').prop('disabled', false);
      });
     
    } else {
      $(".bulk-check").each(function () {
        $(this).prop('checked', false);
        $('#bulk-delete button').prop('disabled', true);
      });
    }
  });


  $(document).on('submit', '#bulk-delete', function (e) {
    e.preventDefault();
    let ids = getIds()
    $('#getId').val(ids);

    $.ajax({
      type: "GET",
      url: $('#bulk-delete').attr('action'),
      data: $('#bulk-delete').serialize(),
      success: function (data) {
           
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
    
    
  // complete status check 

  $('#complete_check').on('show.bs.modal', function (e) {
    $(this).find('.status_btn').attr('href', $(e.relatedTarget).data('href'));
  });


  $(document).on('click', '.status_btn', function (e) {
    e.preventDefault();
    var send = `<span class="spinner-grow spinner-grow-sm"  role="status"></span> Sending Mail...`;
    $(this).html(send);
    var link = $(this).attr('href');

    $.ajax({
      type: "GET",
      url: link,
      success: function (data) {
        $('.alert-success').show();
        $('.alert-success p').html(data);
        $('#geniustable').DataTable().ajax.reload();
        $('#complete_check .close').click();
      }
    });


 
    

  })

  });
  
});