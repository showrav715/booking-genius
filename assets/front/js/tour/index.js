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
			sort = $(this).val();
			$('#tour .sort').val(sort);
			$("#tour_ajax_load").load(mainurl+'/tours?country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
			$(".ajax_loader").fadeOut(1000);
		});

		$(document).on('change', '#view_count', function () {
			$('.ajax_loader').show();
			view = $(this).val();
			$('#tour .view').val(view);
			$("#tour_ajax_load").load(mainurl+'/tours?country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
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
			$("#tour_ajax_load").load(mainurl+'/tours?country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
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
				$("#tour_ajax_load").load($(this).attr('href')+'&country_id='+country+'&review='+review+'&sort='+sort+'&view='+view+'&minPrice='+minPrice+'&maxPrice='+maxPrice+'&page_type=false');
			}
			
		})

// checkout js
		
		        
	$(document).on('click','.payment-check',function(){
		var val = $(this).val();
		if ($(this).is(":checked")) {
			if (val == 'Stripe') {
				$('.card-elements').prop('required', true);
				$('#payment-form').prop('action', $('#tour_stripe_route').val());
				$('.string-show').removeClass('d-none');
				$('.offline-show').addClass('d-none');
				checkMercadopago(0);
			} else if (val == 'Instamojo') {
				checkMercadopago(0);
				$('#payment-form').prop('action', $('#tour_instamojo_route').val());
				$('.string-show').addClass('d-none');
				$('.offline-show').addClass('d-none');
				$('.card-elements').prop('required', false);
			}
			else if (val == 'Paypal') {
				checkMercadopago(0);
				$('#payment-form').prop('action', $('#tour_paypal_route').val());
				$('.string-show').addClass('d-none');
				$('.offline-show').addClass('d-none');
				$('.card-elements').prop('required', false);
			}
			else if (val == 'Authorize') {
				
				$('#payment-form').prop('action', $('#tour_authorize_route').val());
				$('.string-show').removeClass('d-none');
				$('.offline-show').addClass('d-none');
				$('.card-elements').prop('required', true);
				checkMercadopago(0);
			}
			else if (val == 'Mollie') {
				checkMercadopago(0);
				$('#payment-form').prop('action', $('#tour_mollie_route').val());
				$('.string-show').addClass('d-none');
				$('.card-elements').prop('required', false);
				$('.offline-show').addClass('d-none');
			}
			else if (val == 'Paystack') {
				checkMercadopago(0);
				$('#payment-form').prop('action', $('#tour_paystack_route').val());
				$('#payment-form').addClass('step1-form');
				$('.string-show').addClass('d-none');
				$('.card-elements').prop('required', false);
				$('.offline-show').addClass('d-none');
			}
			else if (val == 'Razorpay') {
				checkMercadopago(0);
				$('#payment-form').prop('action', $('#tour_rezorpay_route').val());
				$('.string-show').addClass('d-none');
				$('.card-elements').prop('required', false);
				$('.offline-show').addClass('d-none');
			}
			else if (val == 'Mercadopago') {
				$('#payment-form').prop('action', $('#tour_mercadopago_route').val());
				$('#payment-form').addClass('mercadopago');
				checkMercadopago(1);
				$('.string-show').addClass('d-none');
				$('.card-elements').prop('required', false);
				$('.offline-show').addClass('d-none');
			}
			else {
				checkMercadopago(0);
				$('#payment-form').prop('action', $('#tour_offline_route').val());
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
	  $(".mercadapago-show").removeClass("d-none");
	  $(".mercadapago-show select#docType").prop("required", true);

	  const mp = new MercadoPago($("#tourmercadopagokey").val());

	  const cardNumberElement = mp.fields
		.create("cardNumber", {
		  placeholder: "Card Number",
		})
		.mount("cardNumber");

	  const expirationDateElement = mp.fields
		.create("expirationDate", {
		  placeholder: "MM/YY",
		})
		.mount("expirationDate");

	  const securityCodeElement = mp.fields
		.create("securityCode", {
		  placeholder: "Security Code",
		})
		.mount("securityCode");

	  (async function getIdentificationTypes() {
		try {
		  const identificationTypes = await mp.getIdentificationTypes();

		  const identificationTypeElement =
			document.getElementById("docType");
		  console.log(identificationTypeElement);

		  createSelectOptions(identificationTypeElement, identificationTypes);
		} catch (e) {
		  return console.error("Error getting identificationTypes: ", e);
		}
	  })();

	  function createSelectOptions(
		elem,
		options,
		labelsAndKeys = {
		  label: "name",
		  value: "id",
		}
	  ) {
		const { label, value } = labelsAndKeys;

		//heem.options.length = 0;

		const tempOptions = document.createDocumentFragment();

		options.forEach((option) => {
		  const optValue = option[value];
		  const optLabel = option[label];

		  const opt = document.createElement("option");
		  opt.value = optValue;
		  opt.textContent = optLabel;

		  tempOptions.appendChild(opt);
		});

		elem.appendChild(tempOptions);
	  }
	  cardNumberElement.on("binChange", getPaymentMethods);
	  async function getPaymentMethods(data) {
		const { bin } = data;
		const { results } = await mp.getPaymentMethods({
		  bin,
		});
		console.log(results);
		return results[0];
	  }

	  async function getIssuers(paymentMethodId, bin) {
		const issuears = await mp.getIssuers({
		  paymentMethodId,
		  bin,
		});
		console.log(issuers);
		return issuers;
	  }

	  async function getInstallments(paymentMethodId, bin) {
		const installments = await mp.getInstallments({
		  amount: document.getElementById("transactionAmount").value,
		  bin,
		  paymentTypeId: "credit_card",
		});
	  }

	  async function createCardToken() {
		const token = await mp.fields.createCardToken({
		  cardholderName,
		  identificationType,
		  identificationNumber,
		});
	  }
	  let doSubmit = false;
	  $(document).on("submit", ".mercadopago", function (e) {
		getCardToken();
		e.preventDefault();
	  });
	  async function getCardToken() {
		if (!doSubmit) {
		  const token = await mp.fields.createCardToken({
			cardholderName: document.getElementById("cardholderName").value,
			identificationType: document.getElementById("docType").value,
			identificationNumber: document.getElementById("docNumber").value,
		  });
		  setCardTokenAndPay(token.id);
		}
	  }

	  function setCardTokenAndPay(token) {
		const form = document.querySelector("#payment-form");
		$("#token").val(token);
		doSubmit = true;
		form.submit();
	  }
	} else {
	  $(".mercadapago-show").addClass("d-none");
	  $(".mercadapago-show select#docType").prop("required", false);
	  $(".mercadapago-show input#docNumber").prop("required", false);
	  $(".mercadapago-show input#cardholderName").prop("required", false);
	}
  }
	

    });
});