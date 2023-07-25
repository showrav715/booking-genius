@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Website Contents') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item" aria-current="page">{{ __('Genarel Setting') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Website Contents') }}</li>
      </ol>
  </div>

  <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{__('Website Contents')}}</h6>
      </div>
      <div class="card-body">
        <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">@csrf
             @include('includes.admin.form-both')
              <div class="form-group row">
                  <label for="title" class="col-sm-3 col-form-label">{{ __('Website Title') }}</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="website_title" id="title" placeholder="{{ __('Website Title') }}" value="{{$gs->website_title}}">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="theme_color" class="col-sm-3 col-form-label">{{ __('Theme Color') }}</label>
                  <div class="col-sm-9 input-group colorpicker-component cp">
                      <input type="text" class="form-control cp colorpicker-element" id="theme_color" name="theme_color" placeholder="{{ __('Theme Color') }}" value="{{ $gs->theme_color }}">
                      <span class="input-group-addon"><i></i></span>
                  </div>
              </div>

              <div class="form-group row mb-5">
                  <label for="secendary_color" class="col-sm-3 col-form-label">{{ __('Secendary Color') }}</label>
                  <div class="col-sm-9 input-group colorpicker-component cp">
                      <input type="text" class="form-control cp colorpicker-element" id="secendary_color" name="secendary_color" placeholder="{{ __('Secendary Color') }}" value="{{ $gs->secendary_color }}">
                      <span class="input-group-addon"><i></i></span>
                  </div>
              </div>

              <div class="form-group row mt-5">
                  <label for="secendary_color" class="col-sm-3 col-form-label">{{ __('Sign Up Verification') }}</label>
                  <div class="col-sm-9">
                      <div class="btn-group mb-1">
                          <button type="button" class="btn {{ $gs->is_verification == 1 ? 'btn-success' : 'btn-danger' }} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $gs->is_verification == 1 ? __('Activated') : __('Deactivated') }}
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                              <a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','1,is_verification')}}">{{ __('Activated') }}</a>
                              <a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','0,is_verification')}}">{{ __('Deactivated') }}</a>
                          </div>
                      </div>
                  </div>
              </div>


              <div class="form-group row mt-5">
                  <label for="secendary_color" class="col-sm-3 col-form-label">{{ __('Disqus') }}</label>
                  <div class="col-sm-9">
                      <div class="btn-group mb-1">
                          <button type="button" class="btn {{ $gs->is_disqus == 1 ? 'btn-success' : 'btn-danger' }} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $gs->is_disqus == 1 ? __('Activated') : __('Deactivated') }}
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                              <a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','1,is_disqus')}}">{{ __('Activated') }}</a>
                              <a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','0,is_disqus')}}">{{ __('Deactivated') }}</a>
                          </div>
                      </div>
                  </div>
              </div>

             
              <div class="form-group row">
                  <label for="disqus" class="col-sm-3 col-form-label">{{ __('Disqus Website Short Name') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="disqus" name="disqus" placeholder="{{ __('Disqus Website Short Name') }}" value="{{ $gs->disqus }}">
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


