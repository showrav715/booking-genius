@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Social Links') }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Social Links') }}</li>
        </ol>
    </div>
 <div class="row">
      

<div class="col-lg-12">

      <div class="card-body">
        @include('includes.admin.form-both')
      
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">{{ __('Social Links') }}</h6>
            </div>
            <div class="card-body">
                <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                <form id="pageForm" class="form-horizontal" action="{{ route('admin-social-update') }}" method="POST">  
                    @csrf 
                
                <div class="form-group row">
                  <label for="facebook_link" class="col-sm-3 col-form-label">{{ __('Facebook') }}</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="facebook_link" name="facebook" placeholder="{{ __('Enter Facebook Link') }}" value="{{ $data->facebook }}">
                  </div>
                  <div class="col-sm-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="f_status" value="1" id="f_status" {{ $data->f_status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="f_status"> </label>
                      </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="google_link" class="col-sm-3 col-form-label">{{ __('Google +') }}</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="google_link" name="gplus" placeholder="{{ __('Enter Google Link') }}" value="{{ $data->gplus }}">
                  </div>
                  <div class="col-sm-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="g_status" value="1" id="g_status" {{ $data->g_status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="g_status"> </label>
                      </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="twitter_link" class="col-sm-3 col-form-label">{{ __('Twitter') }}</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="twitter_link" name="twitter" placeholder="{{ __('Enter Twitter Link') }}" value="{{ $data->twitter }}">
                  </div>
                  <div class="col-sm-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="t_status" value="1" id="t_status" {{ $data->t_status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="t_status"> </label>
                      </div>
                  </div>
                </div>


                <div class="form-group row">
                  <label for="linkedin" class="col-sm-3 col-form-label">{{ __('Linkedin') }}</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="{{ __('Enter Linkedin Link') }}" value="{{ $data->linkedin }}">
                  </div>
                  <div class="col-sm-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="l_status" value="1" id="l_status" {{ $data->l_status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="l_status"> </label>
                      </div>
                  </div>
                </div>


                <div class="form-group row">
                  <label for="dribble_link" class="col-sm-3 col-form-label">{{ __('Dribble') }}</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="linkedin" name="dribble" placeholder="{{ __('Enter Dribble Link') }}" value="{{ $data->dribble }}">
                  </div>
                  <div class="col-sm-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="d_status" value="1" id="d_status" {{ $data->d_status == 1 ? 'checked' : '' }}>
                        <label class="custom-control-label" for="d_status"> </label>
                      </div>
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
  </div>
  



@endsection

