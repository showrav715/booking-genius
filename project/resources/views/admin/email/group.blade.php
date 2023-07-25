@extends('layouts.admin')
    
@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Group Mail') }}
   
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Email Setting') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Group Mail') }}</a></li>
        </ol>
    </div>
    @include('includes.admin.form-error')
    @include('includes.admin.form-success')
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="row py-3">
                    <div class="col-md-6 image-area d-none text-center offset-3">
                        <img src="" class="img-fluid"  alt="image">
                    </div>
                </div>
                <div class="card-body">
                    <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form action="{{route('admin-group-submit')}}" enctype="multipart/form-data" method="POST" id="pageForm">
                        @csrf
                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type">{{ __('Select Type') }}</label>
                                    <select class="form-control  mb-3" id="type" name="type">
                                        <option value="" selected disabled>{{__('Select Type')}}</option>
                                        <option value="user">{{__('All User')}}</option>
                                        <option value="subscriber">{{__('Subscribers')}}</option>
                                        <option value="staff">{{__('Staff')}}</option>
                                    </select>
                                  </div>        
                            </div>
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="subject">{{ __('Email Subject') }}</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="{{ __('Email Subject') }}">
                            </div>
                            </div>
                    
                            <div class="col-md-12">
                        <div class="form-group">
                            <label for="body">{{ __('Message') }}</label>
                            <textarea id="body" class="form-control nic-edit" name="body" placeholder="{{ __('Description') }}"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" id="insertButton" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection