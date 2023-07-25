@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Logo') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item" aria-current="page">{{ __('General Setting') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Logo') }}</li>
      </ol>
  </div>
  @include('includes.admin.form-both')
  <div class="row">
    <div class="col-md-6"><div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('Header Logo') }}</h6>
        </div>
        <div class="card-body">
            <div class="text-center image-view-header mb-4">
                <img class="img-profile" src="{{ $gs->header_logo ? asset('assets/images/genarel-settings/'.$gs->header_logo) : asset('assets/images/noimage.png') }}" style="max-width: 100px">
            </div>
            <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="text/plain" method="POST">@csrf
            
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="header-logo" name="header_logo">
                    <label class="custom-file-label" for="header-logo">{{ __('Choose file') }}</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-6"><div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('Footer Logo') }}</h6>
        </div>
        <div class="card-body">
            <div class="text-center image-view-footer mb-4">
                <img class="img-profile" src="{{ $gs->footer_logo ? asset('assets/images/genarel-settings/'.$gs->footer_logo) : asset('assets/images/noimage.png') }}" style="max-width: 100px;">
            </div>
            <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
            <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">@csrf
              

            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="footer-logo" name="footer_logo">
                    <label class="custom-file-label" for="footer-logo">{{ __('Choose file') }}</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
</div>



@endsection


@section('script')
<script>
   
</script>
@endsection