@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Website Language') }}
    <a href="{{ route('admin-lang-index') }}" class="btn back-btn btn-sm text-white">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-lang-index')}}">{{ __('Language') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Website Language') }}</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                     
                        <div class="col-md-3 col-lg-3 offset-4">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger validation">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <ul class="text-left">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                            </div>
                            @endif 
                            <div class="loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                            <form action="{{route('website.lang.import')}}" method="post" enctype="multipart/form-data">@csrf
                                <div class="form-group">
                                    <label for="language">{{ __('File Upload') }}</label>
                                    <span class="ml-3">{{ __('(support (csv))') }}</span>
                                    <div class="custom-file">
                                        <input type="hidden" name="language_id" value="{{$data->id}}">
                                        <input type="file" class="custom-file-input" name="csvfile" id="language"  value="">
                                        <label class="custom-file-label" for="language">{{ __('Choose file') }}</label>
                                    </div>
                                </div>
                                <div class="more-field text-center">
                                    <button type="submit" class="btn btn-info btn-sm">Upload</button>
                                </div>
                            </form>
                        </div>
    
                    </div>
                    <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form action="{{route('admin-lang-update',$data->id)}}" enctype="multipart/form-data" method="POST" id="pageForm">
                        @csrf
    
                        <div class="row mb-2">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="Language">{{ __('Language') }}</label>
                                    <input type="text" class="form-control" name="language" id="Language" placeholder="Language Name" value="{{ $data->language }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{ __('Language Direction') }} </label>
                                    <select name="rtl" class="form-control">
                                        <option value="1" {{$data->rtl == 1 ? 'selected' : ''}}>{{ __('Left to Right') }}</option>
                                        <option value="0" {{$data->rtl == 0 ? 'selected' : ''}}>{{ __('Right to Left') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <h4 class="border-buttom py-3 mb-4 text-center">{{ __('SET LANGUAGE KEYS & VALUES') }}</h4>
                        <div id="language-section">
                            @php
                                $data =   Session::get('data');
                            @endphp
                            @if($data == null)
                            @foreach($lang as $key => $value)
                            <div class="language-area  position-relative">
                                <span class="remove-btn language-remove"><i class="fas fa-times"></i></span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-6">
                                        <div class="form-group">
                                            <textarea name="keys[]" class="form-control" placeholder="Enter Language Key" required="">{{ $key }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-6">
    
                                        <div class="form-group">
                                            <textarea name="values[]" class="form-control" placeholder="Enter Language Value" required="">{{ $value }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if($data)
                            @foreach($data as $key => $value)
                            <div class="language-area  position-relative">
                                <span class="remove-btn language-remove"><i class="fas fa-times"></i></span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-6">
                                        <div class="form-group">
                                            <textarea name="keys[]" class="form-control" placeholder="Enter Language Key" required="">{{ $key }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-6">
    
                                        <div class="form-group">
                                            <textarea name="values[]" class="form-control" placeholder="Enter Language Value" required="">{{ $value }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
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

