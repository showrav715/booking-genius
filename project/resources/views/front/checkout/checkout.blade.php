@extends('layouts.front')
@section('title')
	{{__('Hotel Checkout')}} | {{$gs->website_title}}
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

        <!-- Checkout Area Start -->
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

                                        <div id="cardNumber"></div>
                                        <div id="expirationDate"></div>
                                        <div id="securityCode"> </div>
                                        <input type="hidden" name="token" value="" id="token">
        
                                        <div class="form-group pb-2">
                                            <input class="form-control" type="text" id="cardholderName"
                                                data-checkout="cardholderName" placeholder="{{ __('Card Holder Name') }}"
                                                required />
                                        </div>
                                        <div class="form-group py-2">
                                            <input class="form-control" type="text" id="docNumber" data-checkout="docNumber"
                                                placeholder="{{ __('Document Number') }}" required />
                                        </div>
        
                                        <div class="form-group py-2">
                                            <select id="docType" class="form-control ttt" name="docType" data-checkout="docType"
                                                type="text"></select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="ref_id" id="ref_id" value="">
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
                                    <input type="hidden" name="currency_code" value="{{PriceHelper::showCurrencyCode()}}">
                                    <input type="hidden" name="currency_sign" value="{{PriceHelper::showCurrency()}}">
                                    <div class="col-lg-12 mt-4">
                                          <button type="submit" class="mybtn1 checkout-btn mt-3 final-btn">{{__('Checkout')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="booking-info">
                            <div class="top-area">
                                <h5 class="name">{{$book['hotel']['title']}}</h5>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> {{$book['hotel']->country->country}}, {{$book['hotel']->state->state}}</p>
                                <div class="image">
                                    <img src="{{asset('assets/images/hotel-image/'.$book['hotel']->image->image)}}" alt="">
                                </div>
                            </div>
                            <div class="area-two">
                                <ul>
                                    <li>
                                        <span>{{__('Start date')}}:</span>
                                        <span>{{$book['start_date']}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('End date')}}:</span>
                                        <span>{{$book['end_date']}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('Duration')}}:</span>
                                        <span>{{$book['night']}} {{__('Night')}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('Adult')}}:</span>
                                        <span>{{$book['adult']}}</span>
                                    </li>
                                    <li>
                                        <span>{{__('Children')}}:</span>
                                        <span>{{$book['children']}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="area-three">
                                <ul>
                                    @foreach ($book['rooms'] as $key => $room)
                                    <li>
                                        <span>{{$room->room_name}} * {{$book['room_qty'][$key]}} </span>
                                        <span> {{PriceHelper::showCurrency()}} {{PriceHelper::showPrice($room->per_night_cost * $book['room_qty'][$key])}}</span>
                                    </li>
                                    @endforeach
                                </ul>
                                @if($book['fac_name'])
                                <h6 class="mt-2">
                                    {{__('Extra Prices')}}:
                                </h6>
                                @endif
                                <ul>
                                    @if($book['fac_name'])
                                    @foreach ($book['fac_name'] as $key => $e_p_name)
                                    <li>
                                        <span>{{$e_p_name}}: <small>({{str_replace('_',' ',$book['fac_type'][$key])}})</small></span>
                                        <span>{{PriceHelper::showCurrency()}} {{PriceHelper::showPrice($book['fac_price'][$key])}}</span>
                                    </li>
                                    @endforeach
                                    @endif
                                    <li>
                                        <b>{{__('Hotel Service Charge')}}: </b>
                                        <span>{{PriceHelper::showCurrency()}} {{PriceHelper::showPrice($gs->hotel_service_fee)}}</span>
                                    </li>
                                    
                                </ul>
                               
                            </div>
                            <div class="area-four">
                                <h4>
                                    {{__('Total')}}:
                                </h4>
                                <h4 class="total">
                                     {{PriceHelper::showCurrencyPrice($book['total'])}} 
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <input type="hidden" id="hotel_offline_route" value="{{route('offline.payment')}}">
       <input type="hidden" id="hotel_stripe_route" value="{{route('stripe.submit')}}">
       <input type="hidden" id="hotel_instamojo_route" value="{{route('hotel.instamojo.payment')}}">
       <input type="hidden" id="hotel_paypal_route" value="{{route('hotel.paypal.payment')}}">
       <input type="hidden" id="hotel_authorize_route" value="{{route('hotel.authorize.payment')}}">
       <input type="hidden" id="hotel_mollie_route" value="{{route('hotel.mollie.payment')}}">
       <input type="hidden" id="hotel_paystack_route" value="{{route('hotel.paystack.payment')}}">
       <input type="hidden" id="hotel_mercadopago_route" value="{{route('hotel.mercadopago.payment')}}">
       <input type="hidden" id="hotel_rezorpay_route" value="{{route('hotel.rezorpay.payment')}}">

       @php
       $paystack = App\Models\PaymentGateway::whereKeyword('paystack')->first();
       $paystackData = $paystack->convertAutoData();
   
       $mercadopago = App\Models\PaymentGateway::whereKeyword('Mercadopago')->first();
       $mercadopagoData = $mercadopago->convertAutoData();
   @endphp
   <input type="hidden" value="{{$mercadopagoData['public_key']}}" id="mercadopagokey">
@endsection



@section('script')
<script src="https://js.stripe.com/v2/"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
    $(document).on('submit','.step1-form',function(){
        
        var total = '{{PriceHelper::showPrice($book['total'])}}';
        
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


<script src="{{asset('assets/front/js/hotel/index.js')}}"></script>

@endsection