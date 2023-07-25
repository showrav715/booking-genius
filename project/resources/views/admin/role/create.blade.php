@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Role Create') }}   <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a></h1>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Role Create') }}</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-lg-12">
      @include('includes.admin.form-both')
      <!-- General Element -->
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">{{ __('Role Create') }}</h6>
        </div>
        <div class="card-body">
          <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
          <form action="{{ route('admin-role-store') }}" method="POST" id="pageForm">
            @csrf
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label">{{ __('Role Name') }}</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Enter Role Name') }}">
              </div>
            </div>
            <hr>
            <h4 class="text-center mr-5">{{__('Role Permission')}}</h4>
            <hr>
          <div class="row ">
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="blogsection"  value="Blog Section">
                  <label class="custom-control-label" for="blogsection">{{ __('Blog Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="hotelsection"  value="Hotel Section">
                  <label class="custom-control-label" for="hotelsection">{{ __('Hotel Section')}}</label>
              </div>
            </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="toursection"  value="Tour Section">
                  <label class="custom-control-label" for="toursection">{{ __('Tour Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="spacesection"  value="Space Section">
                  <label class="custom-control-label" for="spacesection">{{ __('Space Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="carsection"  value="Car Section">
                  <label class="custom-control-label" for="carsection">{{ __('Car Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="gs_settings"  value="General Settings Section">
                  <label class="custom-control-label" for="gs_settings">{{ __('General Settings Section') }}</label>
                </div>
              </div>
            </div>


            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="ps_setting"  value="Home Page Settings Section">
                  <label class="custom-control-label" for="ps_setting">{{ __('Home Page Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="pay_setting"  value="Payment Settings Section">
                  <label class="custom-control-label" for="pay_setting">{{ __('Payment Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="menu_settings"  value="Menu Page Settings Section">
                  <label class="custom-control-label" for="menu_settings">{{ __('Menu Page Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="email_settings" value="Email Settings Section"> 
                  <label class="custom-control-label" for="email_settings">{{ __('Email Settings Section') }}</label>
                </div>
              </div>
            </div>


            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="social_settings"  value="Social Settings Section">
                  <label class="custom-control-label" for="social_settings">{{ __('Social Settings Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="location"  value="Location Section">
                  <label class="custom-control-label" for="location">{{ __('Location Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="languagesection"  value="Language Section">
                  <label class="custom-control-label" for="languagesection">{{ __('Language Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="seo_tools" value="Seo Tools Section">
                  <label class="custom-control-label" for="seo_tools">{{ __('Seo Tools Section') }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="staffsection"  value="Manage Staff Section">
                  <label class="custom-control-label" for="staffsection">{{ __('Manage Staff Section') }}</label>
                </div>
              </div>
            </div>
            
            
          

            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="newsletter" value="User Manage Section">
                  <label class="custom-control-label" for="newsletter">{{ __('User Manage Section') }}</label>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="role" value="Manage Role Section">
                  <label class="custom-control-label" for="role">{{ __('Manage Role Section') }}</label>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="section[]" class="custom-control-input" id="role" value="Subscriber Section">
                  <label class="custom-control-label" for="role">{{ __('Subscriber Section') }}</label>
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

