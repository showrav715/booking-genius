@extends('layouts.front')
@section('title')
	{{__('Car Checkout')}} | {{$gs->website_title}}
@endsection
@section('content')

    	<!--Main Breadcrumb Area Start -->
<div class="main-breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="pagetitle">
							{{__('Checkout')}}
						</h1>
						<ul class="pages">
							<li>
								<a href="{{route('front.index')}}">
									{{__('Home')}}
								</a>
							</li>
							<li class="active">
								<a href="javascript:;">
									{{__('Checkout')}}
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--Main Breadcrumb Area End -->

        <section class="checkout-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="submission-area">
                            <h4 class="title">
                                {{__('Booking Submission')}}
                            </h4>
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible m-2 p-1">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                            <form action="javascript:;" method="POST" id="payment-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">{{__('Name')}} *</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="{{__('Name')}}" value="{{$user->name}}">
                                            @error('name')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{__('Email')}} *</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="{{__('Email')}}" value="{{$user->email}}">
                                            @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="number">{{__('Mobile Number')}} *</label>
                                            <input type="text" class="form-control" id="number" name="number" placeholder="{{__('Mobile Number')}}" value="{{$user->phone}}">
                                            @error('number')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_line_1">{{__('Address line')}}</label>
                                            <input type="text" class="form-control" id="address_line_1" name="address" placeholder="{{__('Your Address line')}}" value="{{$user->address}}">
                                            @error('address')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">{{__('City')}}</label>
                                            <input type="text" class="form-control" id="city" name="city" placeholder="{{__('City')}}">
                                            @error('city')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">{{__('State/Province/Region')}}</label>
                                            <input type="text" class="form-control" id="state" name="state" placeholder="{{__('State/Province/Region')}}">
                                            @error('state')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zip_code">{{__('Zip code')}}</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="{{__('Zip code')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">{{__('Country')}}</label>
                                            <input type="text" class="form-control" id="country" name="country" placeholder="{{__('country')}}">
                                            @error('country')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="summery">{{__('Special Requirements')}}</label>
                                            <textarea class="form-control" name="summery" id="summery" rows="4" placeholder="{{__('Special Requirements')}}"></textarea>
                                          </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <h4 class="title">
                                            {{__('Select Payment Method')}}
                                        </h4>
                                    </div>
                                    <div class="col-lg-12">
                                        @foreach ($gateweys as $key => $gatewey)
                                        <div class="custom-control custom-radio mb-2">
                                            <input type="radio" id="customRadio{{$key}}" name="method" class="custom-control-input payment-check" value="{{$gatewey->keyword ? $gatewey->keyword : $gatewey->title}}" data-href="{{$gatewey->details}}">
                                            <label class="custom-control-label"  for="customRadio{{$key}}">{{$gatewey->type == 'automatic' ? $gatewey->name : $gatewey->title }} {{__('Payment')}}</label>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="col-lg-12 d-none string-show">
                                        <div class="border p-3 mt-3">
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="card_number">{{__('Card Number')}}</label>
                                                        <input type="text" class="form-control card-elements" name="cardNumber" id="validateCard" placeholder="{{ __('Card Number')}}" autocomplete="off">
                                                        <span id="errCard" class="text-danger"></span>
                                                        @error('cardNumber')
                                                        <p>{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cardCVC">{{__('Cvc')}}</label>
                                                        <input type="text" class="form-control card-elements" id="validateCVC"  placeholder="{{__('Cvc')}}" name="cardCVC" >
                                                        <span id="errCVC text-danger"></span>
                                                        @error('cardCVC')
                                                        <p>{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Month')}}</label>
                                                        <input type="text" class="form-control card-elements" id="" placeholder="{{__('Month')}}" name="month">
                                                        @error('name')
                                                        <p>{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Year')}}</label>
                                                        <input type="text" class="form-control card-elements" id="" placeholder="{{__('Year')}}" name="year">
                                                        @error('year')
                                                        <p>{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 d-none mercadapago-show">
                                        <div class="border p-3 mt-3">
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="card_number">{{__('Card Number')}}</label>
                                                        <input type="text" class="form-control " id="cardNumber" data-checkout="cardNumber" onselectstart="return false" autocomplete="off" >
                                                        <span id="errCard" class="text-danger"></span>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cardCVC">{{__('Cvc')}}</label>
                                                        <input type="text" class="form-control " id="securityCode" data-checkout="securityCode" placeholder="{{ __('Security Code') }}" onselectstart="return false" autocomplete="off"  >
                                                        <span id="errCVC text-danger"></span>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Month')}}</label>
                                                        <input type="text" class="form-control " id="cardExpirationMonth" data-checkout="cardExpirationMonth" placeholder="{{ __('Expiration Month') }}" autocomplete="off" >
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Year')}}</label>
                                                        <input type="text" class="form-control "id="cardExpirationYear" data-checkout="cardExpirationYear" placeholder="{{ __('Expiration Year') }}" autocomplete="off" >
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Card Name')}}</label>
                                                        <input type="text" class="form-control " id="cardholderName" data-checkout="cardholderName" placeholder="{{ __('Card Holder Name') }}" >
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="docType" id="dc-label">{{ __('Document type') }}</label>
                                                        <select class="form-control" id="docType" data-checkout="docType" >
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('Document Number')}}</label>
                                                        <input type="text" class="form-control " id="docNumber" data-checkout="docNumber" placeholder="{{ __('Document Number') }}" >
                                                        
                                                    </div>
                                                </div>

                                                <input type="hidden" id="installments" value="1"/>
                                                <input type="hidden" name="amount" id="amount"/>
                                                <input type="hidden" name="description"/>
                                                <input type="hidden" name="paymentMethodId" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 d-none offline-show">
                                        <div class="border p-3 mt-3">
                                            <p><b class="details_show_offline"></b></p>
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="card_number">{{__('Transaction ID')}}</label>
                                                        <input type="text" class="form-control" name="transaction_id"  placeholder="{{ __('Transaction ID')}}" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1"> I have read and accept the <a href="#">terms and conditions</a></label>
                                          </div>
                                          <input type="hidden" name="currency_code" value="{{PriceHelper::showCurrencyCode()}}">
                                          <input type="hidden" name="currency_sign" value="{{PriceHelper::showCurrency()}}">
                                          <input type="hidden" name="ref_id" id="ref_id" value="">
                                          <button class="mybtn1 final-btn mt-3">{{__('Checkout')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="booking-info">
                            <div class="top-area">
                                <h5 class="name">{{$car['car']['title']}}</h5>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> {{$car['car']->country->country}}, {{$car['car']->state->state}}</p>
                                <div class="image">
                                    <img src="{{asset('assets/images/car/feature-image/'.$car['car']->image->image)}}" alt="">
                                </div>
                            </div>
                            <div class="area-two">
                                <ul>
                                    <li>
                                        <span>{{__('Start date')}}:</span>
                                        <span>{{$car['start_date']}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('End date')}}:</span>
                                        <span>{{$car['end_date']}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('Duration')}}:</span>
                                        <span>{{$car['night']}} {{__('Night')}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('Car Quantity')}}:</span>
                                        <span>{{$car['qty']}}</span>
                                    </li>
                                    
                                </ul>
                            </div>
                            @if($car['fac_name'])
                            <div class="area-three">
                                <h6 class="mt-2">
                                    {{__('Extra Prices')}}:
                                </h6>
                                <ul>
                                    @foreach ($car['fac_name'] as $key => $e_p_name)
                                    <li>
                                        <span>{{$e_p_name}}: <small>({{str_replace('_',' ',$car['fac_type'][$key])}})</small></span>
                                        <span>{{PriceHelper::showCurrencyPrice($car['fac_price'][$key])}}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="area-four">
                                <h4>
                                    {{__('Total')}}:
                                </h4>
                                <h4 class="total">
                                     {{PriceHelper::showCurrencyPrice($car['total'])}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Checkout Area End -->
        <input type="hidden" id="car_offline_route" value="{{route('car.offline.payment')}}">
        <input type="hidden" id="car_stripe_route" value="{{route('car.stripe.payment')}}">
        <input type="hidden" id="car_instamojo_route" value="{{route('car.instamojo.payment')}}">
        <input type="hidden" id="car_paypal_route" value="{{route('car.paypal.payment')}}">
        <input type="hidden" id="car_authorize_route" value="{{route('car.authorize.payment')}}">
        <input type="hidden" id="car_mollie_route" value="{{route('car.mollie.payment')}}">
        <input type="hidden" id="car_paystack_route" value="{{route('car.paystack.payment')}}">
        <input type="hidden" id="car_mercadopago_route" value="{{route('car.mercadopago.payment')}}">
        <input type="hidden" id="car_rezorpay_route" value="{{route('car.rezorpay.payment')}}">

    @php
        $paystack = App\Models\PaymentGateway::whereKeyword('paystack')->first();
        $paystackData = $paystack->convertAutoData();
    
        $mercadopago = App\Models\PaymentGateway::whereKeyword('Mercadopago')->first();
        $mercadopagoData = $mercadopago->convertAutoData();
    @endphp
    <input type="hidden" value="{{$mercadopagoData['public_key']}}" id="carmercadopagokey">
@endsection


@section('script')
<script src="https://js.stripe.com/v2/"></script>
<script src="{{asset('assets/front/js/car/index.js')}}"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
    $(document).on('submit','.step1-form',function(){
        
        var total = '{{PriceHelper::showPrice($car['total'])}}';
        
            var handler = PaystackPop.setup({
                key: '{{$paystackData['key']}}',
                email: $('input[name=email]').val(),
                amount: total * 100,
                currency: "{{PriceHelper::showCurrencyCode()}}",
                ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                callback: function(response){
                $('#ref_id').val(response.reference);
                $('#payment-form').removeClass('step1-form');
                $('.final-btn').click();
                },
                onClose: function(){
                window.location.reload();
                }
            });
            handler.openIframe();
                return false;
            
        });
</script>

@endsection