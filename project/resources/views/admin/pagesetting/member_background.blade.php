@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Member Section Background') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item" aria-current="page">{{ __('Home Page Setting') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Member Section Background') }}</li>
      </ol>
  </div>
</div>


<div class="row">
    <div class="col-md-12"><div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{ __('Member Section Background') }}</h6>
        </div>
        @include('includes.admin.form-both')
        <div class="card-body">
            <div class="text-center image-view mb-4">
                <img class="image-fluid border p-3" src="{{ $ps->member_background ? asset('assets/images/page-setting/'.$ps->member_background) : asset('assets/images/noimage.png') }}" width="500" height="250">
            </div>
            <div class="col-lg-6 col-md-12 offset-lg-3 col-sm-12">
              
              <div class="loader" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
              <form id="pageForm" action="{{ route('admin-member-background-update') }}" enctype="multipart/form-data" method="POST">@csrf
               
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="member_background" id="breadcum_banner">
                    <label class="custom-file-label" for="member_background">{{ __('Choose file') }}</label>
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

