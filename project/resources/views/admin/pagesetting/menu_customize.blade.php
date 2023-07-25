@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Menu Customization') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Menu Settings') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Menu Customization') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error')
     @include('includes.admin.form-success')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{ __('Menu Customization') }}</h6>
                </div>
                <div class="card-body align-item-center">
                    <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form id="pageForm" action="{{ route('admin-homepage-menu-update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                          <label for="tour_menu" class="col-sm-3 col-form-label">{{ __('Tour') }}</label>
                          <div class="col-sm-9">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="tour_menu" name="tour_menu" value="1" {{ $ps->tour_menu == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="tour_menu"> </label>
                              </div>
                          </div>
                        </div>

                      <div class="form-group row">
                        <label for="hotel_menu" class="col-sm-3 col-form-label">{{ __('Hotel') }}</label>
                        <div class="col-sm-9">
                          <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="hotel_menu" name="hotel_menu" value="1" {{ $ps->hotel_menu == 1 ? 'checked' : '' }}>
                              <label class="custom-control-label" for="hotel_menu"> </label>
                            </div>
                        </div>
                      </div>

                     
                    <div class="form-group row">
                      <label for="space_menu" class="col-sm-3 col-form-label">{{ __('Space') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="space_menu" name="space_menu" value="1" {{ $ps->space_menu == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="space_menu"> </label>
                          </div>
                      </div>
                    </div>
                  
                    <div class="form-group row">
                      <label for="car_menu" class="col-sm-3 col-form-label">{{ __('Car') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="car_menu" name="car_menu" value="1" {{ $ps->car_menu == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="car_menu"> </label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="blog_menu" class="col-sm-3 col-form-label">{{ __('Blog') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="blog_menu"  id="blog_menu" value="1" {{ $ps->blog_menu == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="blog_menu"> </label>
                          </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="pages_menu" class="col-sm-3 col-form-label">{{ __('Pages') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="pages_menu" name="pages_menu" value="1" {{ $ps->pages_menu == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="pages_menu"> </label>
                          </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="contact_menu" class="col-sm-3 col-form-label">{{ __('Contact') }}</label>
                      <div class="col-sm-9">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="contact_menu" name="contact_menu" value="1" {{ $ps->contact_menu == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="contact_menu"> </label>
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

