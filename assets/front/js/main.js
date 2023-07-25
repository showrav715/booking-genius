$(function ($) {
  "use strict";

  jQuery(document).ready(function () {
    // Serch option toggle
    $(".web-serch").on("click", function () {
      $(".search-form-area-mobile").show();
    });

    $(".off-serch").on("click", function () {
      $(".search-form-area-mobile").hide();
    });

    // Menu DropDown Start
    $(".nav-item.dropdown").on("mouseover", function () {
      $(".nav-item.dropdown .dropdown-menu").stop().show(600);
    });

    $(".nav-item.dropdown").on("mouseout", function () {
      $(".nav-item.dropdown .dropdown-menu").stop().hide(600);
    });
    // Menu DropDown End

    //   magnific popup activation Strat
    $(".video-play-btn, .play-video").magnificPopup({
      type: "video",
    });

    $(".img-popup").magnificPopup({
      type: "image",
    });
    //   magnific popup activation End


    //  Hero Slider Active

    var BasicSlider = $(".banner-active");
    BasicSlider.on("init", function (e, slick) {
      var $firstAnimatingElements = $(".single-banner:first-child").find(
        "[data-animation]"
      );
      doAnimations($firstAnimatingElements);
    });
    BasicSlider.on(
      "beforeChange",
      function (e, slick, currentSlide, nextSlide) {
        var $animatingElements = $(
          '.single-banner[data-slick-index="' + nextSlide + '"]'
        ).find("[data-animation]");
        doAnimations($animatingElements);
      }
    );
    BasicSlider.slick({
      autoplay: true,
      autoplaySpeed: 5000,
      dots: false,
      fade: true,
      arrows: true,
      prevArrow: '<span class="prev"><i class="fas fa-angle-left"></i></span>',
      nextArrow: '<span class="next"><i class="fas fa-angle-right"></i></span>',
      responsive: [
        {
          breakpoint: 1330,
          settings: {
            arrows: false,
          },
        },
      ],
    });

    function doAnimations(elements) {
      var animationEndEvents =
        "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
      elements.each(function () {
        var $this = $(this);
        var $animationDelay = $this.data("delay");
        var $animationType = "animated " + $this.data("animation");
        $this.css({
          "animation-delay": $animationDelay,
          "-webkit-animation-delay": $animationDelay,
        });
        $this.addClass($animationType).one(animationEndEvents, function () {
          $this.removeClass($animationType);
        });
      });
    }

    // Select 2 active js
    $(document).ready(function () {
      $(".location-select").select2();
    });

    // Product deal countdown
    $("[data-countdown]").each(function () {
      var $this = $(this),
        finalDate = $(this).data("countdown");

      $this.countdown(finalDate, function (event) {
        $this.html(
          event.strftime(
            "<span>%D : <small>Days</small></span> <span>%H  <small>Hrs</small></span>"
          )
        );
      });
    });

    $(function () {
      $('input[name="daterange"]').daterangepicker(
        {
          opens: "left",
        },
        function (start, end, label) {}
      );

      $(".select-date").daterangepicker({
        singleDatePicker: true,
        disabledPast: true,
      });
    });

    // Tour-Slider Area Start
    var $team_slider = $(".tour-slider");
    $team_slider.owlCarousel({
      loop: true,
      navText: [
        '<i class="fas fa-angle-double-left"></i>',
        '<i class="fas fa-angle-double-right"></i>',
      ],
      nav: true,
      dots: false,
      autoplay: true,
      items:3,
      margin: 30,
      autoplayTimeout: 6000,
      smartSpeed: 1000,
      responsive: {
        0: {
          items: 1,
        },
        767: {
          items: 2,
        },
        992: {
          items: 3,
        },
        1200: {
          items: 3,
        },
        1920: {
          items: 3,
        },
      },
    });
    // Team-slider Area End

    /**------------------------------
     * Product Details  carousel
     * ---------------------------**/
    $(".one-item-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".all-item-slider",
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            vertical: false,
            horizontal: true,
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    $(".all-item-slider").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: ".one-item-slider",
      arrows: true,
      prevArrow: '<i class="fa fa fa-chevron-left slidPrv4"></i>',
      nextArrow: '<i class="fa fa-chevron-right slidNext4"></i>',
      dots: false,
      centerMode: false,
      centerPadding: "20px",
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            vertical: false,
            horizontal: true,
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        
      ],
    });




  });

  // Testimonial-slider Start
  var $testimonial_slider = $(".testimonial-slider");
  $testimonial_slider.owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    autoplay: false,
    margin: 30,
    autoplayTimeout: 6000,
    smartSpeed: 1000,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
      1200: {
        items: 3,
      },
    },
  });
  // Testimonial-slider End

  // back to top Start
  $(document).on("click", ".bottomtotop", function () {
    $("html,body").animate(
      {
        scrollTop: 0,
      },
      2000
    );
  });
  // back to top End

  //define variable for store last scrolltop
  var lastScrollTop = "";
  $(window).on("scroll", function () {
    var $window = $(window);
    if ($window.scrollTop() > 0) {
      $(".mainmenu-area").addClass("nav-fixed");
    } else {
      $(".mainmenu-area").removeClass("nav-fixed");
    }

    // back to top show / hide
    var st = $(this).scrollTop();
    var ScrollTop = $(".bottomtotop");
    if ($(window).scrollTop() > 1000) {
      ScrollTop.fadeIn(1000);
    } else {
      ScrollTop.fadeOut(1000);
    }
    lastScrollTop = st;
  });

  $(window).on("load", function () {
    // Preloader
    var preLoder = $("#preloader");
    preLoder.addClass("hide");
    var backtoTop = $(".back-to-top");

    // back to top
    var backtoTop = $(".bottomtotop");
    backtoTop.fadeOut(100);
  });

  


  // stripe validate check
  var cnstatus = false;
  var cvcStatus = false;

  $(document).on("keyup", "#validateCVC", function () {
    cvcStatus = Stripe.card.validateCVC($(this).val());
    if (!cvcStatus) {
      $("#errCVC").html("CVC number not valid");
    } else {
      $("#errCVC").html("");
    }
  });

  $(document).on("keyup", "#validateCard", function () {
    cnstatus = Stripe.card.validateCardNumber($(this).val());
    if (!cnstatus) {
      $("#errCard").html("Card number not valid<br>");
    } else {
      $("#errCard").html("");
    }
  });
  // stripe validate check

  // language setup

  $(document).on("change", "#language_setup", function () {
    let language_id = $(this).val();
    let language_url = $(this).attr("data-target") + "?language=" + language_id;

    $.ajax({
      type: "GET",
      url: language_url,
      success: function (data) {
        if (data.success == 1) {
          location.reload();
        }
      },
    });
  });

  // language setup

  // currency setup

  $(document).on("change", "#currency_setup", function () {
    let currency_id = $(this).val();
    let currency_url = $(this).attr("data-target") + "?currency=" + currency_id;

    $.ajax({
      type: "GET",
      url: currency_url,
      success: function (data) {
        if (data.success == 1) {
          location.reload();
        }
      },
    });
  });
  // currency setup
  
    $("#accordion, #accordion2").accordion({
    heightStyle: "content",
    collapsible: true,
    icons: {
      "header": "ui-icon-caret-1-e",
      "activeHeader": "ui-icon-caret-1-s"
    }
  });
});
