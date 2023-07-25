@extends('layouts.admin')


@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Facebook Login') }} <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Social Settings') }}</li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Facebook Login') }}</li>
      </ol>
  </div>

  <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">{{__('Facebook Login')}}</h6>
      </div>
      <div class="card-body">
        <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form id="pageForm" action="{{ route('admin-social-update-all') }}" enctype="multipart/form-data" method="POST">@csrf
             @include('includes.admin.form-both')

              <div class="form-group row mt-5">
                  <label for="secendary_color" class="col-sm-3 col-form-label">{{ __('Facebook Login') }}</label>
                  <div class="col-sm-9">
                      <div class="btn-group mb-1">
                          <button type="button" class="btn dropdown-toggle {{ $data->f_check == 1 ? 'btn-success' : 'btn-danger' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             {{ $data->f_check == 1 ? __('Activated') : __('Deactivated') }}
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                              <a class="dropdown-item social-status-check cursor-pointer" data-href="{{route('admin-social-facebookup',1)}}">{{ __('Activated') }}</a>
                              <a class="dropdown-item social-status-check cursor-pointer" data-href="{{route('admin-social-facebookup',0)}}">{{ __('Deactivated') }}</a>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="form-group row mb-5">
                  <label for="fclient_id" class="col-sm-3 col-form-label">{{ __('App ID') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="fclient_id" name="fclient_id" placeholder="{{ __('App ID') }}" value="{{$data->fclient_id}}">
                  </div>
              </div>

              <div class="form-group row mb-5">
                  <label for="fclient_secret" class="col-sm-3 col-form-label">{{ __('App Secret') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="fclient_secret" name="fclient_secret" placeholder="{{ __('App Secret') }}" value="{{$data->fclient_secret}}">
                  </div>
              </div>


              <div class="form-group row mb-5">
                  <label for="website_url" class="col-sm-3 col-form-label">{{ __('Website URL') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="website_url" name="website_url" placeholder="{{ __('Website URL') }}" value="{{url('/')}}">
                  </div>
              </div>


              <div class="form-group row mb-5">
                  <label for="fclient_secret" class="col-sm-3 col-form-label">{{ __('Valid OAuth Redirect URI') }}</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="fredirect" name="fredirect" placeholder="{{ __('Valid OAuth Redirect URI') }}" value="{{$data->fredirect}}">
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

