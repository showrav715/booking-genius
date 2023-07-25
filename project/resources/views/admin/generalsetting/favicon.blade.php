@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Favicon') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item" aria-current="page">{{ __('General Setting') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Favicon') }}</li>
      </ol>
  </div>
</div>


<div class="row">
    <div class="col-md-12"><div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('Favicon') }}</h6>
        </div>
        <div class="card-body">
            <div class="text-center  image-view-favicon mb-4">
                <img class="img-profile rounded-circle" src="{{ $gs->favicon ? asset('assets/images/genarel-settings/'.$gs->favicon) : asset('assets/images/noimage.png') }}" style="max-width: 60px;">
            </div>
            <div class="col-lg-6 col-md-12 offset-lg-3 col-sm-12">
              <div class="loader" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
              <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">@csrf
                @include('includes.admin.form-both')
              <div class="form-group">
                  <div class="custom-file">
                      <input type="file" class="custom-file-input" name="favicon" id="favicon">
                      <label class="custom-file-label" for="favicon">{{ __('Choose file') }}</label>
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

