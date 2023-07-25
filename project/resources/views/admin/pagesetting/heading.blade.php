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
     <div class="row">
        <div class="col-lg-6 offset-3">
            <!-- Form Basic -->
            @include('includes.admin.form-both')
              <div class="card-body">
              
                <form id="pageForm" action="{{route('admin-homepage-heading-update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="form-group mt-2">
                      <label for="destination_title">{{ __('Destinations Title') }}</label>
                        <input type="text" class="form-control" name="destination_title" id="destination_title" placeholder="{{ __('Destinations Title') }}" value="{{$data->destination_title}}">
                    </div>
                    
                    <div class="form-group mt-2">
                      <label for="tour">{{ __('Tour Title') }}</label>
                        <input type="text" class="form-control" name="tour_title" id="tour" placeholder="{{ __('Tour Title') }}" value="{{$data->tour_title}}">
                    </div>
                    
                    <div class="form-group mt-2">
                      <label for="hotel_title">{{ __('Hotel Title') }}</label>
                        <input type="text" class="form-control" name="hotel_title" id="hotel_title" placeholder="{{ __('Hotel Title') }}" value="{{$data->hotel_title}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="car_title">{{ __('Car Title') }}</label>
                        <input type="text" class="form-control" name="car_title" id="car_title" placeholder="{{ __('Car Title') }}" value="{{$data->car_title}}">
                    </div>
                
                    <div class="form-group mt-2">
                      <label for="space_title">{{ __('Space Title') }}</label>
                        <input type="text" class="form-control" name="space_title" id="space_title" placeholder="{{ __('Space Title') }}" value="{{$data->space_title}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="blog_title">{{ __('Blog Title') }}</label>
                        <input type="text" class="form-control" name="blog_title" id="blog_title" placeholder="{{ __('Blog Title') }}" value="{{$data->blog_title}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="blog_subtitle">{{ __('Blog Sub Title') }}</label>
                        <input type="text" class="form-control" name="blog_subtitle" id="blog_subtitle" placeholder="{{ __('Blog Sub Title') }}" value="{{$data->blog_subtitle}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="member_title">{{ __('Member Title') }}</label>
                        <input type="text" class="form-control" name="member_title" id="member_title" placeholder="{{ __('Member Title') }}" value="{{$data->member_title}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="member_text">{{ __('Member Text') }}</label>
                        <input type="text" class="form-control" name="member_text" id="member_text" placeholder="{{ __('Member Text') }}" value="{{$data->member_text}}">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </form>
                </div>
            </div>
    </div>
    <input type="hidden" value="1" id="isValue">

@endsection

