$(function ($) {
  "use strict";




 // Model Gallery Start
 var $modelslider = $(".model-slider");
 $modelslider.slick({
   fade: true,
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: true,
   prevArrow: '<i class="fa fa fa-chevron-left slidPrv4"></i>',
   nextArrow: '<i class="fa fa-chevron-right slidNext4"></i>',
 });

 $('.modal').on('shown.bs.modal', function (e) {
   $('.model-slider').slick('setPosition');
   $('.model-gallery-image').addClass('open');
 })
 
 // Model Gallery End



  //  SUBSCRIBE FORM SUBMIT SECTION

  $(document).on("submit", "#subscribeform", function (e) {
    e.preventDefault();
    $("#sub-btn").prop("disabled", true);
    $.ajax({
      method: "POST",
      url: $(this).prop("action"),
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data.errors) {
          $.notify(data.errors, "error");
        } else {
          $("#subemail").val("");
          $.notify(data, "success");
        }

        $("#sub-btn").prop("disabled", false);

        $("#subemail").val("");
      },
    });
  });

  //  SUBSCRIBE FORM SUBMIT SECTION ENDS

  //**************************** GLOBAL CAPCHA****************************************

  $(".refresh_code").on("click", function () {
    $.get($(this).data("href"), function (data, status) {
      $(".codeimg").attr(
        "src",
        "" + mainurl + "/assets/images/capcha_code.png?time=" + Math.random()
      );
    });
  });

  //**************************** GLOBAL CAPCHA ENDS****************************************

  // CONTACT  FORM SUBMIT SECTION ********************//

  $(document).on("submit", "#contactform", function (e) {
    e.preventDefault();
    $(".gocover").show();
    $("button.submit-btn").prop("disabled", true);
    $.ajax({
      method: "POST",
      url: $(this).prop("action"),
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        $("#contactform .spinner-grow").removeClass("d-none");
      },
      success: function (data) {
        if (data.errors) {
          $(".alert-success").hide();
          $(".alert-danger").show();
          $(".alert-danger ul").html("");
          for (var error in data.errors) {
            $("#contactform .spinner-grow").addClass("d-none");
            $(".alert-danger ul").append("<li>" + data.errors[error] + "</li>");
          }
          $(
            "#contactform input[type=text], #contactform input[type=email], #contactform textarea"
          )
            .eq(0)
            .focus();
          $(".refresh_code").trigger("click");
        } else {
          $("#contactform .spinner-grow").addClass("d-none");
          $(".alert-danger").hide();
          $(".alert-success").show();
          $(".alert-success p").html(data);
          $(
            "#contactform input[type=text], #contactform input[type=email], #contactform textarea"
          )
            .eq(0)
            .focus();
          $(
            "#contactform input[type=text], #contactform input[type=email], #contactform textarea"
          ).val("");
          $(".refresh_code").trigger("click");
        }
        $(".gocover").hide();
        $("button.submit-btn").prop("disabled", false);
      },
    });
  });

  // CONTACT  FORM SUBMIT SECTION END ********************//

  // Favarite ADD REMOVE JS START //
  $(document).on("click", ".add-favotite", function () {
    let userInfo = $("#user_id").val();
    let show = $(this);
    if (userInfo) {
      let favurl = $(this).attr("data-href");
      $.get(favurl, function (res) {
        if (res.status == 1) {
          $(show).html('<i class="fas fa-check"></i>');
        } else if (res.status == 0) {
          $(show).html('<i class="far fa-heart"></i>');
        }
        $.notify(res.message, "success");
      });
    } else {
      window.location = mainurl + "/user/login";
    }
  });
  // Favarite ADD REMOVE JS END //

  //  review section js start //
  $(document).on("click", ".review-value i", function () {
    $(".review-value i").css("color", "#bdbdbd");
    let reviewValue = $(this).attr("data");
    let parentClass = `review-${reviewValue}`;
    $("." + parentClass + " i").css("color", "#ff9800");
    $("#reviewValue").val(reviewValue);
  });
  //  review section js end //

  //  review section js start //
  $(document).ready(function () {
    let reviewValue = $("#now_review").val();
    var parentClass = `review-${reviewValue}`;
    $("." + parentClass + " i").css("color", "#ff9800");
    $("#reviewValue").val(reviewValue);
  });
  //  review section js end //
});
