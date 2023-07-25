@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Google Analytics') }} </h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboaard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Social Settings') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Google Analytics') }}</li>
      </ol>
  </div>

  <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{__('Google Analytics')}}</h6>
      </div>
      <div class="card-body">
        <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-seotool-analytics-update') }}" enctype="multipart/form-data" method="POST">@csrf
             @include('includes.admin.form-both')

              <div class="form-group row mb-5">
                  <label for="google_analytics" class="col-sm-3 col-form-label">{{ __('Google Analytics ID') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="google_analytics" name="google_analytics" placeholder="{{ __('Google Analytics ID') }}" value="{{$tool->google_analytics}}">
                  </div>
              </div>


              <div class="form-group row mb-5">
                  <label for="facebook_pixel" class="col-sm-3 col-form-label">{{ __('Facebook Pixel ID') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="facebook_pixel" name="facebook_pixel" placeholder="{{ __('Facebook Pixel ID') }}" value="{{$tool->facebook_pixel}}">
                  </div>
              </div>
              <div class="form-group row mb-5">
                  <label for="meta_keys" class="col-sm-3 col-form-label">{{ __('Meta Keywords') }}</label>
                  <div class="col-sm-9">
                    <input type="text"  id="meta_keys" name="meta_keys" value="{{ $tool->meta_keys }}">
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
<input type="hidden" value="1" id="isValue">
@endsection

