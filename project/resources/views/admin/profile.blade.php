@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Profile') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.profile')}}">{{ __('Profile') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            @include('includes.admin.form-both')
              <div class="card-body">
              
                <form id="pageForm" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group ShowLanguageImage text-center mb-2  {{ $data ? '' : 'd-none'}}">
                      <img src="{{ $data->photo != null ? asset('assets/images/admins/'.$data->photo) : asset('assets/images/noimage.png')}}" class="rounded-circle img-fluid" alt="image" width="150">
                  </div>
                  <div class="form-group">
                      <label for="languageimage">{{ __('Image') }}</label>
                      <span class="ml-2">{{ __('(support (jpeg,jpg,png))') }}</span>
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" name="photo" id="image" value="" accept="image/*">
                          <input type="hidden" value="" id="image_file">
                          <label class="custom-file-label" for="languageimage">{{ __('Choose file') }}</label>
                      </div>
                  </div>
                  
                    <div class="form-group mt-2">
                      <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{$data->name}}">
                    </div>
                    
                    <div class="form-group mt-2">
                      <label for="email">{{ __('Email') }}</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('Email') }}" value="{{$data->email}}">
                    </div>
                    
                    <div class="form-group mt-2">
                      <label for="phone">{{ __('Phone') }}</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="{{ __('Phone') }}" value="{{$data->phone}}">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </form>
                </div>
            </div>
    </div>
</div>
<input type="hidden" value="1" id="isValue">
@endsection
