(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  $("#wrapper .sidebar a").each(function() {
    var pageUrl = window.location.href.split(/[#]/)[0];
    if (this.href == pageUrl) {
      if($(this).parent().hasClass('collapse-inner')){
        $(this).addClass("active"); // add active to li of the current link
        $(this).parent().parent().parent().addClass("active");
        $(this).parent().parent().prev().click();
      }else{
				$(this).parent().addClass("active"); // add active to li of the current link
      }


    }
  });


  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

        // IMAGE UPLOADING :)
        $(".image-upload").on( "change", function() {
          var imgpath = $(this).parent().prev();
          var file = $(this);
          readURL(this,imgpath);
        });

        function readURL(input,imgpath) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              imgpath.css('background', 'url('+e.target.result+')');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
        // IMAGE UPLOADING ENDS :)

  // NORMAL FORM

  $(document).on('submit','.geniusform',function(e){

      var $this = $(this);

      e.preventDefault();
      if(admin_loader == 1)
      {
      $('.gocover').show();
      }

    $('#submit-btn').prop('disabled',true);
        $.ajax({
         method:"POST",
         url:$(this).prop('action'),
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         success:function(data)
         {
            if ((data.errors)) {
            $this.find('.alert-success').hide();
            $this.find('.alert-danger').show();
            $this.find('.alert-danger ul').html('');
              for(var error in data.errors)
              {
                $this.find('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
              }
            }
            else
            {
              $this.find('.alert-danger').hide();
              $this.find('.alert-success').show();
              $this.find('.alert-success p').html(data);


            }
            if(admin_loader == 1)
            {
                $('.gocover').hide();
            }

            $('#submit-btn').prop('disabled',false);
            
            $(window).scrollTop(0);

         }

        });

  });

  // NORMAL FORM ENDS

  // NORMAL TAB FORM

    $(document).on('submit','.geniusform-tab',function(e){

      var $this = $(this);

      e.preventDefault();

      var pass = 1;

      $('form.geniusform-tab').find('input, select').each(function(){
        if($(this).prop('required')){
          if ($(this).val() === "") {
            pass = 0;
          }
        }
      });
    
      if (pass === 0) {
        toastr.error(form_error);
      }else {

        if(admin_loader == 1)
        {
        $('.gocover').show();
        }

        $('#submit-btn').prop('disabled',true);
        $.ajax({
         method:"POST",
         url:$(this).prop('action'),
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         success:function(data)
         {
            if ((data.errors)) {
            $this.find('.alert-success').hide();
            $this.find('.alert-danger').show();
            $this.find('.alert-danger ul').html('');
              for(var error in data.errors)
              {
                $this.find('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
              }
            }
            else
            {
              $this.find('.alert-danger').hide();
              $this.find('.alert-success').show();
              $this.find('.alert-success p').html(data);


            }
            if(admin_loader == 1)
            {
                $('.gocover').hide();
            }

            $('#submit-btn').prop('disabled',false);
            
            $(window).scrollTop(0);

         }

        });

      }



  });

  // NORMAL TAB FORM ENDS

  // POPUP MODAL

  $('.confirm-modal').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });

  $('.confirm-modal .btn-ok').on('click', function(e) {

  if(admin_loader == 1)
  {
  $('.submit-loader').show();
  }

    $.ajax({
    type:"GET",
    url:$(this).attr('href'),
    success:function(data)
    {
          $('.confirm-modal').modal('hide');
          table.ajax.reload();
          $('.alert-danger').hide();
          $('.alert-success').show();
          $('.alert-success p').html(data);

          if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }

    }
    });
    return false;
  });

  // POPUP MODAL ENDS

// STATUS SECTION

$('.drop-change').on('click',function(){
  var $this = $(this);
  var link = $this.data('href');
  var btn = $this.parent().prev();
  var lastClass = btn.attr('class').split(' ').pop();
  btn.removeClass(lastClass);
  if($this.data('status') == '1'){
    btn.addClass('btn-success');
  }else{
    btn.addClass('btn-danger');
  }
  btn.text($this.data('val'));

  $.get(link, function(data) {
  }).done(function(data) {
    toastr.success(data);
  })

});

// STATUS SECTION ENDS

$('.mytags').tagify();

$('.summernote').summernote({
  height: 150
});

$('.next-prev').on('click',function(){
  $($(this).data('href')).click();
});

$(document).on('click','.hide-close',function(){
    $(this).parent().hide();
});


})(jQuery); // End of use strict

// Modal Javascript

$(document).ready(function () {
  
  $("#myBtn").click(function () {
    $('.modal').modal('show');
  });

  $("#modalLong").click(function () {
    $('.modal').modal('show');
  });

  $("#modalScroll").click(function () {
    $('.modal').modal('show');
  });

  $('#modalCenter').click(function () {
    $('.modal').modal('show');
  });

});

// Popover Javascript

$(function () {
  $('[data-toggle="popover"]').popover()
});

$('.popover-dismiss').popover({
  trigger: 'focus'
});

function shownotification(){
  $("#notclear").html('0');
  $route = $("#notclear").data("href");
  $.get($route);
  $('#notf-show').load($('#notf-show').data('href'));
}

$(document).on('click','#clear-notf',function(){
  $.get($(this).data('href'));
});

  // Status Start
  $(document).on('click','.status',function () {
    var link = $(this).attr('data-href');
        $.get( link, function() {
          }).done(function(data) {
              table.ajax.reload();
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success p').html(data);
        })
      });
// Status Ends

$(document).on('click','.dropdown-toggle',function(){
  let $this = $(this);
  if($this.parent().hasClass('show')){
    $this.parent().removeClass('show');
    $this.next().removeClass('show');
  }else{
    $this.parent().addClass('show');
    $this.next().addClass('show');
  }
});
