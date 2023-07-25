@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Home Page Background') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Home Page Settings') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Home Page Background') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error')
     @include('includes.admin.form-success')
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="row py-3">
                    <div class="col-md-6 image-area {{ $ps->home_page_photo != null ? '' : 'd-none' }} text-center offset-3">
                        <img src="{{ $ps->home_page_photo != null ? asset('assets/images/page-setting/'.$ps->home_page_photo) : '' }}" class="img-fluid"  alt="image">
                    </div>
                </div>
                <div class="card-body">
                    <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form id="pageForm" action="{{ route('admin-homepage-update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                          <label for="video_image" class="col-sm-3 col-form-label">{{ __('Background Image') }}</label>
                          <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="home_page_photo" id="video_image" accept="image/*">
                                <label class="custom-file-label" for="video_image">{{ __('Choose file') }}</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="title" class="col-sm-3 col-form-label">{{ __('Title') }}</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="home_page_title" value="{{ $ps->home_page_title }}" id="title" placeholder="{{ __('Title') }}">
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

