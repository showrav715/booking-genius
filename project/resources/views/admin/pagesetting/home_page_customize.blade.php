@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Home Page Customization') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Home Page Settings') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Home Page Customization') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error')
     @include('includes.admin.form-success')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{ __('Home Page Customization') }}</h6>
                </div>
                <div class="card-body align-item-center">
                    <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form id="pageForm" action="{{ route('admin-homepage-update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                      <div class="form-group row">
                        <label for="feature_section" class="col-sm-3 col-form-label">{{ __('Feature Section') }}</label>
                        <div class="col-sm-9">
                          <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="feature_section" name="feature_section" value="1" {{ $ps->feature_section == 1 ? 'checked' : '' }}>
                              <label class="custom-control-label" for="feature_section"> </label>
                            </div>
                        </div>
                      </div>
                    <div class="form-group row">
                      <label for="destinition" class="col-sm-3 col-form-label">{{ __('Destinations Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="destinition" name="destinations_section" value="1" {{ $ps->destinations_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="destinition"> </label>
                          </div>
                      </div>
                    </div>
                  
                    <div class="form-group row">
                      <label for="tour_section" class="col-sm-3 col-form-label">{{ __('Tours Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="tour_section" name="tour_section" value="1" {{ $ps->tour_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="tour_section"> </label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="car_section" class="col-sm-3 col-form-label">{{ __('Car Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="car_section"  id="car_section" value="1" {{ $ps->car_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="car_section"> </label>
                          </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="hotel_section" class="col-sm-3 col-form-label">{{ __('Hotel Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="hotel_section" name="hotel_section" value="1" {{ $ps->hotel_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="hotel_section"> </label>
                          </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="space_section" class="col-sm-3 col-form-label">{{ __('Space Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="space_section" name="space_section" value="1" {{ $ps->space_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="space_section"> </label>
                          </div>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="member" class="col-sm-3 col-form-label">{{ __('Member Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="member" name="member_section" value="1" {{ $ps->member_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="member"> </label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="blog_section" class="col-sm-3 col-form-label">{{ __('Blog Section') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="blog_section" name="blog_section" value="1" {{ $ps->blog_section == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="blog_section"> </label>
                          </div>
                      </div>
                    </div>
                   
                    <div class="form-group row">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
             
            </div>
        </div>
    </div>


@endsection

