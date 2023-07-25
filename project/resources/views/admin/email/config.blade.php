@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Email Configuration') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>    
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboaard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Email Configuration') }}</li>
      </ol>
  </div>

  <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{__('Email Configuration')}}</h6>
      </div>
      <div class="card-body">
        <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-gs-update') }}" enctype="multipart/form-data" method="POST">@csrf
             @include('includes.admin.form-both')

              <div class="form-group row ">
                  <label for="secendary_color" class="col-sm-3 col-form-label">{{ __('SMTP') }}</label>
                  <div class="col-sm-9">
                      <div class="btn-group mb-1">
                          <button type="button" class="btn dropdown-toggle {{ $gs->is_smtp == 1 ? 'btn-success' : 'btn-danger' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             {{ $gs->is_smtp == 1 ? __('Activated') : __('Deactivated') }}
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                              <a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','1,is_smtp')}}">{{ __('Activated') }}</a>
                              <a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','0,is_smtp')}}">{{ __('Deactivated') }}</a>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="form-group row mb-3">
                  <label for="smtp_host" class="col-sm-3 col-form-label">{{ __('SMTP Host') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="smtp_host" name="smtp_host" placeholder="{{ __('SMTP Host') }}" value="{{$gs->smtp_host}}">
                  </div>
              </div>

              <div class="form-group row mb-3">
                  <label for="smtp_port" class="col-sm-3 col-form-label">{{ __('SMTP Port') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="smtp_port" name="smtp_port" placeholder="{{ __('SMTP Port') }}" value="{{$gs->smtp_port}}">
                  </div>
              </div>

             
              <div class="form-group row mb-3">
                  <label for="smtp_user" class="col-sm-3 col-form-label">{{ __('SMTP Username') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="smtp_user" name="smtp_user" placeholder="{{ __('SMTP Username') }}" value="{{ $gs->smtp_user }}">
                  </div>
              </div>


              <div class="form-group row mb-3">
                  <label for="smtp_pass" class="col-sm-3 col-form-label">{{ __('SMTP Password') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="smtp_pass" name="smtp_pass" placeholder="{{ __('SMTP Password') }}" value="{{ $gs->smtp_pass }}">
                  </div>
              </div>


              <div class="form-group row mb-3">
                  <label for="from_email" class="col-sm-3 col-form-label">{{ __('From Email') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="from_email" name="from_email" placeholder="{{ __('From Email') }}" value="{{ $gs->from_email }}">
                  </div>
              </div>


              <div class="form-group row mb-3">
                  <label for="from_name" class="col-sm-3 col-form-label">{{ __('From Name') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="from_name" name="from_name" placeholder="{{ __('From Name') }}" value="{{$gs->from_name}}">
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

