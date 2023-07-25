@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create Admin Panel Language') }}
    <a href="{{ route('admin-lang-admin-index') }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Create Admin Panel Language') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-both')
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form action="{{route('admin-lang-admin-store')}}" enctype="multipart/form-data" method="POST" id="pageForm">
                        @csrf
                            <div class="row mb-2">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="Language">{{ __('Language') }}</label>
                                        <input type="text" class="form-control" name="language" id="Language" placeholder="Language Name">
                                      </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{ __('Language Direction') }} </label>
                                        <select name="rtl" class="form-control">
                                            <option value="1">{{ __('Left to Right') }}</option>
                                            <option value="0">{{ __('Right to Left') }}</option>
                                        </select>
                                      </div>
                                </div>
                            </div>
                          

                            <h4 class="border-buttom py-3 mb-4 text-center">{{ __('SET LANGUAGE KEYS & VALUES') }}</h4>

                        <div id="language-section">
                        <div class="language-area  position-relative">
                            <span class="remove-btn language-remove"><i class="fas fa-times"></i></span>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-6">
                                    <div class="form-group">
                                        <textarea name="keys[]" class="form-control" placeholder="Enter Language Key" required=""></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-6">
                                   
                                    <div class="form-group">
                                        <textarea name="values[]" class="form-control" placeholder="Enter Language Value" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                       
                    </div>
                        <div class="more-field text-center">
                            <button type="button" class="btn btn-info" id="language-btn">{{ __('Add More Field') }}</button>
                        </div>

                        <button type="submit" id="insertButton" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="0" id="isValue">
@endsection

