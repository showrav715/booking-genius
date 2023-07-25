
$(function ($) {
    "use strict";


jQuery(document).ready(function () {


        let sort = '';
		let view = $('#viewajax').val();
		let minPrice = $('#minPriceajax').val();
		let maxPrice = $('#maxPriceajax').val();
		let country = $('#country_id_ajax').val();
        let review = $('#reviewajax').val();
        

     

    $(document).on('change', '#sort_by', function () {
        $('.ajax_loader').show();
            let sort = $(this).val();
            $('#tour .sort').val(sort);
            $("#hotel_ajax_load").load(mainurl+'/hotels?country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
            $(".ajax_loader").fadeOut(1000);
    });

    $(document).on('change', '#view_count', function () {
        $('.ajax_loader').show();
                view = $(this).val();
                $('#tour .view').val(view);
                $("#hotel_ajax_load").load(mainurl+'/hotels?country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
                $(".ajax_loader").fadeOut(1000);
    });


    $(document).on('click', '#min_max_price_sort', function () {
        $('.ajax_loader').show();
                minPrice = parseFloat($('#min_price').val());
                maxPrice = parseFloat($('#max_price').val());
                if(isNaN(minPrice)){
                    minPrice = '';
                }
                if(isNaN(maxPrice)){
                    maxPrice = '';
                }

                $('#tour .minprice').val(minPrice);
                $('#tour .maxprice').val(maxPrice);
                $("#hotel_ajax_load").load(mainurl+'/hotels?country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
                $(".ajax_loader").fadeOut(1000);
            
    })

            $(document).on('click','.ajax_country',function(){
             
                country = $(this).attr('data-href');
                $('#tour .country').val(country);
                $('#search-tour').click();
            })

            $(document).on('click','.review_ajax_call',function(){
                let forval = $(this).attr('for');
                review = $('#'+forval).val();
                $('#tour .review').val(review);
                $('#search-tour').click();
            })



            $(document).on('click','.pagination .page-item .page-link',function(e){
                e.preventDefault();
                let paginatelink = $(this).attr('href');
                if(paginatelink){
                $("#hotel_ajax_load").load($(this).attr('href')+'&country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
                }
                
            })
    
    

// checkout js
$(document).on('click','.payment-check',function(){
    var val = $(this).val();
    if ($(this).is(":checked")) {
        if (val == 'Stripe') {
            checkMercadopago(0);
            $('#payment-form').prop('action',$('#hotel_stripe_route').val());
            $('.string-show').removeClass('d-none');
            $('.card-elements').prop('required', true);
            $('.offline-show').addClass('d-none');
        } else if (val == 'Instamojo') {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_instamojo_route').val());
            $('.string-show').addClass('d-none');
            $('.card-elements').prop('required', false);
            $('.offline-show').addClass('d-none');
        }
        else if (val == 'Paypal') {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_paypal_route').val());
            $('.string-show').addClass('d-none');
            $('.card-elements').prop('required', false);
            $('.offline-show').addClass('d-none');
        }
        else if (val == 'Authorize') {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_authorize_route').val());
            $('.string-show').removeClass('d-none');
            $('.card-elements').prop('required', true);
            $('.offline-show').addClass('d-none');
        }
        else if (val == 'Mollie') {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_mollie_route').val());
            $('.string-show').addClass('d-none');
            $('.card-elements').prop('required', false);
            $('.offline-show').addClass('d-none');
        }
        else if (val == 'Paystack') {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_paystack_route').val());
            $('#payment-form').addClass('step1-form');
            $('.string-show').addClass('d-none');
            $('.card-elements').prop('required', false);
            $('.offline-show').addClass('d-none');
        }
            
        else if (val == 'Razorpay') {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_rezorpay_route').val());
            $('.string-show').addClass('d-none');
            $('.card-elements').prop('required', false);
            $('.offline-show').addClass('d-none');
        }
            
         else if (val == 'Mercadopago') {
            $('#payment-form').prop('action', $('#hotel_mercadopago_route').val());
            $('#payment-form').addClass('mercadopago');
            checkMercadopago(1);
            $('.string-show').addClass('d-none');
            $('.card-elements').prop('required', false);
            $('.offline-show').addClass('d-none');
        }
        else {
            checkMercadopago(0);
            $('#payment-form').prop('action', $('#hotel_offline_route').val());
            $('.string-show').addClass('d-none');
            $('.details_show_offline').html($(this).data('href'));
			$('.offline-show').removeClass('d-none');
            $('.card-elements').prop('required', false);
            
        }
    }
})
// checkout js
    
    function checkMercadopago(value) {
        if (value == 1) {
            $('.mercadapago-show').removeClass('d-none');
            $('.mercadapago-show select#docType').prop('required', true);



            window.Mercadopago.setPublishableKey($('#mercadopagokey').val());
            window.Mercadopago.getIdentificationTypes();
      
            function addEvent(to, type, fn){ 
              if(document.addEventListener){
                  to.addEventListener(type, fn, false);
              } else if(document.attachEvent){
                  to.attachEvent('on'+type, fn);
              } else {
                  to['on'+type] = fn;
              }  
          }; 
      
      addEvent(document.querySelector('#cardNumber'), 'keyup', guessingPaymentMethod);
      addEvent(document.querySelector('#cardNumber'), 'change', guessingPaymentMethod);
      
      function getBin() {
          var ccNumber = document.querySelector('input[data-checkout="cardNumber"]');
          return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
      };
      
      function guessingPaymentMethod(event) {
          var bin = getBin();
      
          if (event.type == "keyup") {
              if (bin.length >= 6) {
                  window.Mercadopago.getPaymentMethod({
                      "bin": bin
                  }, setPaymentMethodInfo);
              }
          } else {
              setTimeout(function() {
                  if (bin.length >= 6) {
                      window.Mercadopago.getPaymentMethod({
                          "bin": bin
                      }, setPaymentMethodInfo);
                  }
              }, 100);
          }
      };
      
      function setPaymentMethodInfo(status, response) {
          if (status == 200) {
              const paymentMethodElement = document.querySelector('input[name=paymentMethodId]');
      
              if (paymentMethodElement) {
                  paymentMethodElement.value = response[0].id;
              } else {
                  const input = document.createElement('input');
                  input.setAttribute('name', 'paymentMethodId');
                  input.setAttribute('type', 'hidden');
                  input.setAttribute('value', response[0].id);     
      
                  form.appendChild(input);
              }
      
              Mercadopago.getInstallments({
                  "bin": getBin(),
                  "amount": parseFloat(document.querySelector('#amount').value),
              }, setInstallmentInfo);
      
          } else {
              alert(`payment method info error: ${response}`);  
          }
      };
      
      
      let doSubmit = false;
      addEvent(document.querySelector('.mercadopago'), 'submit', doPay);
      function doPay(event){
          event.preventDefault();
          if(!doSubmit){
              var $form = document.querySelector('.mercadopago');
      
              window.Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below
      
              return false;
          }
      };
      
      function sdkResponseHandler(status, response) {
          if (status != 200 && status != 201) {
              alert("Some of your information is wrong!");
              $('#preloader').hide();
      
          }else{
              var form = document.querySelector('.mercadopago');
              var card = document.createElement('input');
              card.setAttribute('name', 'token');
              card.setAttribute('type', 'hidden');
              card.setAttribute('value', response.id);
              form.appendChild(card);
              doSubmit=true;
              form.submit();
          }
      };
      
      
      function setInstallmentInfo(status, response) {
              var selectorInstallments = document.querySelector("#installments"),
              fragment = document.createDocumentFragment();
              selectorInstallments.length = 0;
      
              if (response.length > 0) {
                  var option = new Option("Escolha...", '-1'),
                  payerCosts = response[0].payer_costs;
                  fragment.appendChild(option);
      
                  for (var i = 0; i < payerCosts.length; i++) {
                      fragment.appendChild(new Option(payerCosts[i].recommended_message, payerCosts[i].installments));
                  }
      
                  selectorInstallments.appendChild(fragment);
                  selectorInstallments.removeAttribute('disabled');
              }
          };
      
            $('#docType').show();
            $('.nice-select').addClass('d-none');



        } else {
            $('.mercadapago-show').addClass('d-none');
            $('.mercadapago-show input.card-elements').prop('required', false);
            $('.mercadapago-show select#docType').prop('required', false);
        }
    }

});
});