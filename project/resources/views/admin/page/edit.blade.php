@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Page') }}
  <a href="{{ route('admin-page-index') }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
  </h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item"><a href="{{route('admin-page-index')}}">{{ __('Pages') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Page') }}</li>
      </ol>
  </div>
  @include('includes.admin.form-error')
  @include('includes.admin.form-success')
  <div class="row">
      <div class="col-lg-12">
          <!-- Form Basic -->
          <div class="card mb-4">
              
              <div class="card-body">
                  <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                  <form id="pageForm" action="{{route('admin-page-update',$data->id)}}" method="POST">
                    @csrf
                      <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                      <input type="text" class="form-control" name="title" required id="title" placeholder="{{ __('Title') }}" value="{{$data->title}}">
                      </div>
                      <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                      <input type="text" class="form-control" name="slug" required id="slug" placeholder="{{ __('Slug') }}" value="{{$data->slug}}">
                      </div>
                  
                       <div class="form-group">
                            <label for="area1">{{ __('details') }}</label>
                             <textarea id="area1" class="form-control nic-edit" name="details">{{ $data->details }}</textarea>
                        </div>
                  
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" name="seocheck"  id="customCheck1" {{ $data->meta_tag != null || $data->meta_description != null ? 'checked': '' }}>
                            <label class="custom-control-label" for="customCheck1"> {{ __('Allow Page SEO') }}</label>
                          </div>
                  
                        <div class="meta_description {{ $data->meta_tag != null || $data->meta_description != null ? '': 'd-none' }} mb-3">
                            <div class="form-group"> 
                                <label for="meta_tag">{{ __('Meta Tag') }}</label>
                                <input type="text" class="form-control" name="meta_tag" id="meta_tag" placeholder="{{ __('Meta Tag') }}" value="{{ $data->meta_tag }}">
                              </div>
                  
                            <div class="form-group">
                                <label for="meta_description">{{ __('Meta Description') }}</label>
                                <input type="text" class="form-control" name="meta_description" id="meta_description" placeholder="{{ __('Meta Description') }}" value="{{ $data->meta_description }}">
                              </div>
                        </div>
                  
                  
                      <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
<input type="hidden" value="1" id="isValue">
@endsection
