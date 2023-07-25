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
          <form id="pageForm" action="{{ route('admin-currency-update',$data->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
             @include('includes.admin.form-both')

              <div class="form-group row mb-3">
                  <label for="name" class="col-sm-3 col-form-label">{{ __('Currency Name') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Currency Name') }}" value="{{$data->name}}">
                  </div>
              </div>

              <div class="form-group row mb-3">
                  <label for="sign" class="col-sm-3 col-form-label">{{ __('Currency Sign') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="sign" name="sign" placeholder="{{ __('Currency Sign') }}" value="{{$data->sign}}">
                  </div>
              </div>

            
              <div class="form-group row mb-3">
                  <label for="value" class="col-sm-3 col-form-label">{{ __('Currency Value') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="value" name="value" placeholder="{{ __('Currency Value') }}" value="{{ $data->value }}">
                  </div>
              </div>


              <div class="form-group row mb-3">
                  <label for="currency_format" class="col-sm-3 col-form-label">{{ __('Currency Format') }}</label>
                  <div class="col-sm-9">
                      <select name="currency_format" class="form-control form-control-sm" id="currency_format">
                        <option value="0" {{$data->currency_format == 0 ? 'selected' : ''}}>{{ __('Before Price') }}</option>
                        <option value="1" {{$data->currency_format == 1 ? 'selected' : ''}} >{{ __('After Price') }}</option>
                      </select>
                  </div>
              </div>

          
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

