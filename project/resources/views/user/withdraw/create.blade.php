@extends('layouts.user')
    
@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create Withdraw') }}
    <a href="{{ route('user-withdraw-index') }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('user-withdraw-index')}}">{{ __('Withdraw') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Create Withdraw') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error')
    @include('includes.admin.form-success')
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->website_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form action="{{route('user-withdraw-store')}}" enctype="multipart/form-data" method="POST" id="pageForm">
                        @csrf

                        <div>
                            <p><strong>{{__('Your Earning Amount')}} : </strong><strong>{{PriceHelper::showAdminCurrencyPrice(Auth::user()->total_earning)}}</strong> </p>
                        </div>
                       
                        <div class="form-group">
                            <label for="amount">{{ __('Enter Amount') }}</label>
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="{{ __('Enter Amount') }}">
                            
                        </div>
                        <div class="charge_show d-none">

                        </div>
                        
                        
                    
                        <div class="form-group">
                            <label for="method">{{ __('Withdraw Methods') }}</label>
                            <select class="form-control  mb-3" id="method" name="method">
                                <option value="" selected disabled>{{__('Select Method')}}</option>
                                @foreach (DB::table('withdraw_methods')->whereStatus(1)->get() as $method)
                                    <option value="{{$method->name}}">{{$method->name}}</option>
                                @endforeach 
                            </select>
                          </div>

                            <div class="form-group">
                                <label for="details">{{ __('Withdraw Account Information') }}</label>
                                <textarea  class="form-control" rows="4" id="details" name="details" placeholder="{{ __('Withdraw Account Information') }}"></textarea>
                            </div>
                    
                        <button type="submit" id="insertButton" class="btn btn-primary">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
      

        $(document).on('keyup','#amount',function(){
            let amount = parseFloat($(this).val());
            if(amount > 0){
                let fixed_amount = parseFloat('{{$gs->withdraw_extra_charge}}');
                let percentage_amount = parseFloat('{{$gs->withdraw_percentage_fee}}');
                let total = 0;
                let sub_total = 0;
                if(fixed_amount > 0){
                    fixed_amount = fixed_amount;
                }
                if(percentage_amount > 0){
                    sub_total = (amount * parseFloat(percentage_amount)) / 100;
                }
                total = parseFloat(amount - sub_total - fixed_amount).toFixed(2);
                let charge = '';
                if(total >= 1){
                     charge = `<p class="text-primary font-weight-bold">{{__('Withdraw Fee')}} {{$gs->withdraw_percentage_fee}}% {{__('And Withdraw Charge')}} {{PriceHelper::showAdminCurrencyPrice($gs->withdraw_extra_charge)}} {{__('Total Withdraw Amount')}} = {{PriceHelper::showAdminCurrency()}}${total}</p>`;
                }else{
                     charge = `<p class="text-danger font-weight-bold">{{__('Withdraw Fee')}} {{$gs->withdraw_percentage_fee}}% {{__('And Withdraw Charge')}} {{PriceHelper::showAdminCurrencyPrice($gs->withdraw_extra_charge)}} {{__('Total Withdraw Amount')}} = {{PriceHelper::showAdminCurrency()}}${total}</p>`;
                }
                
                $('.charge_show').html(charge).removeClass('d-none');
            }else{
                $('.charge_show').html('').addClass('d-none');
            }
        })
    </script>
@endsection