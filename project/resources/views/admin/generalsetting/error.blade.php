@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Error Page') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item" aria-current="page">{{ __('General Setting') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Error Page') }}</li>
      </ol>
  </div>

  <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{__('Error Page')}}</h6>
      </div>
      <div class="card-body">
         
          <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">@csrf
             @include('includes.admin.form-both')
             <div class="text-center image-view-error mb-4 ml-5">
                <img class="image-fluid border p-3" src="{{ $gs->error_photo ? asset('assets/images/genarel-settings/'.$gs->error_photo) : asset('assets/images/noimage.png') }}" width="550" height="280">
              </div>
              <div class="form-group row mb-5 mt-5">
                  <label for="error-image" class="col-sm-3 col-form-label">{{ __('Upload Image') }} *</label>
                  <div class="col-sm-9">
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" name="error_photo" id="error-image">
                          <label class="custom-file-label" for="error-image">{{ __('Upload file') }}</label>
                      </div>
                  </div>
              </div>

              <div class="form-group row mt-5 mb-5">
                  <label for="error_title" class="col-sm-3 col-form-label">{{ __('Error Title') }} *</label>
                  <div class="col-sm-9">
                      <textarea class="form-control" name="error_title" id="error_title" rows="5">{{ $gs->error_title }}</textarea>
                  </div>
              </div>

              <div class="form-group row mb-5">
                  <label for="error_text" class="col-sm-3 col-form-label">{{ __('Error Text') }} *</label>
                  <div class="col-sm-9">
                      <textarea class="form-control " name="error_text" id="error_text" rows="5">{{ $gs->error_text }}</textarea>
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

