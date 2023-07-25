@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Website Footer') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item" aria-current="page">{{ __('General Setting') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Website Footer') }}</li>
      </ol>
  </div>


  <div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">{{__('Website Footer')}}</h6>
    </div>
    <div class="card-body">

      <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
      <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">
        @csrf
         @include('includes.admin.form-both')
        <div class="form-group row mb-5">
          <label for="footer_text" class="col-sm-3 col-form-label">{{ __('Footer Text') }} *</label>
          <div class="col-sm-9">
            <textarea class="form-control" id="footer_text" name="footer_text" rows="5" placeholder="{{ __('Footer Text') }}">{{ $gs->footer_text }}</textarea>
          </div>
        </div>

        <div class="form-group row mb-5">
          <label for="copy_right_text" class="col-sm-3 col-form-label">{{ __('Copyright Text') }} *</label>
          <div class="col-sm-9">
            <textarea class="form-control nic-edit" name="copy_right_text" id="copy_right_text" rows="5">{{ $gs->copy_right_text }}</textarea>
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
