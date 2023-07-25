@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Payment Information') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>    
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Payment Information') }}</li>
      </ol>
  </div>

  <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{__('Payment Information')}}</h6>
      </div>
      <div class="card-body">
        <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">@csrf
             @include('includes.admin.form-both')

              <div class="form-group row mb-3">
                  <label for="withdraw_extra_charge" class="col-sm-3 col-form-label">{{ __('Withdraw Fixed Charge') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="withdraw_extra_charge" name="withdraw_extra_charge" placeholder="{{ __('Withdraw Fixed Charge') }}" value="{{$gs->withdraw_extra_charge}}">
                  </div>
              </div>

              <div class="form-group row mb-3">
                  <label for="withdraw_percentage_fee" class="col-sm-3 col-form-label">{{ __('Withdraw Percentage Charge') }} %</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="withdraw_percentage_fee" name="withdraw_percentage_fee" placeholder="{{ __('Withdraw Percentage Charge') }}" value="{{$gs->withdraw_percentage_fee}}">
                  </div>
              </div>

              <hr>

          
              <div class="form-group row">
                  <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                  </div>
              </div>
          </form>
      </div>
  </div>
</div>

@endsection

