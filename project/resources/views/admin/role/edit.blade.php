@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Role Edit') }}   <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Role Edit') }}</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-lg-12">
      @include('includes.admin.form-both')
      <!-- General Element -->
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Role Edit') }}</h6>
        </div>
        <div class="card-body">
          <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form action="{{ route('admin-role-update',$data->id) }}" method="POST" id="pageForm">
            @csrf
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">{{ __('Role Name') }}</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="{{ __('Enter Role Name') }}">
              </div>
            </div>
            <hr>
            <h4 class="text-center mr-5">{{__('Role Permission')}}</h4>
            <hr>
          <div class="row ">
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="blogsection"  {{in_array('Blog Section',explode(',',$data->section)) ? 'checked' : ''}} value="Blog Section">
                  <label class="custom-control-label" for="blogsection">{{ __('Blog Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="hotelsection" {{in_array('Hotel Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Hotel Section">
                  <label class="custom-control-label" for="hotelsection">{{ __('Hotel Section')}}</label>
              </div>
            </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="toursection" {{in_array('Tour Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Tour Section">
                  <label class="custom-control-label" for="toursection">{{ __('Tour Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="spacesection" {{in_array('Space Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Space Section">
                  <label class="custom-control-label" for="spacesection">{{ __('Space Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="carsection" {{in_array('Car Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Car Section">
                  <label class="custom-control-label" for="carsection">{{ __('Car Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="gs_settings" {{in_array('General Settings Section',explode(',',$data->section)) ? 'checked' : ''}}  value="General Settings Section">
                  <label class="custom-control-label" for="gs_settings">{{ __('General Settings Section') }}</label>
                </div>
              </div>
            </div>


            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="ps_setting" {{in_array('Home Page Settings Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Home Page Settings Section">
                  <label class="custom-control-label" for="ps_setting">{{ __('Home Page Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="pay_setting" {{in_array('Payment Settings Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Payment Settings Section">
                  <label class="custom-control-label" for="pay_setting">{{ __('Payment Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="menu_settings" {{in_array('Menu Page Settings Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Menu Page Settings Section">
                  <label class="custom-control-label" for="menu_settings">{{ __('Menu Page Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="email_settings" {{in_array('Email Settings Section',explode(',',$data->section)) ? 'checked' : ''}} value="Email Settings Section"> 
                  <label class="custom-control-label" for="email_settings">{{ __('Email Settings Section') }}</label>
                </div>
              </div>
            </div>


            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="social_settings" {{in_array('Social Settings Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Social Settings Section">
                  <label class="custom-control-label" for="social_settings">{{ __('Social Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="locations" {{in_array('Location Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Location Section">
                  <label class="custom-control-label" for="locations">{{ __('Location Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="languagesection" {{in_array('Language Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Language Section">
                  <label class="custom-control-label" for="languagesection">{{ __('Language Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="seo_tools" {{in_array('Seo Tools Section',explode(',',$data->section)) ? 'checked' : ''}} value="Seo Tools Section">
                  <label class="custom-control-label" for="seo_tools">{{ __('Seo Tools Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="staffsection" {{in_array('Manage Staff Section',explode(',',$data->section)) ? 'checked' : ''}}  value="Manage Staff Section">
                  <label class="custom-control-label" for="staffsection">{{ __('Manage Staff Section') }}</label>
                </div>
              </div>
            </div>
            
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="newsletter" {{in_array('User Manage Section',explode(',',$data->section)) ? 'checked' : ''}} value="User Manage Section">
                  <label class="custom-control-label" for="newsletter">{{ __('User Manage Section') }}</label>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="role" {{in_array('Manage Role Section',explode(',',$data->section)) ? 'checked' : ''}} value="Manage Role Section">
                  <label class="custom-control-label" for="role">{{ __('Manage Role Section') }}</label>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="subscriber" {{in_array('Subscriber Section',explode(',',$data->section)) ? 'checked' : ''}} value="Subscriber Section">
                  <label class="custom-control-label" for="subscriber">{{ __('Subscriber Section') }}</label>
                </div>
              </div>
            </div>
           <hr>
          
              <div class="col-md-6 offset-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->
</div>

@endsection

