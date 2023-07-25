

@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('User Update') }}
    <a href="{{ route('admin-user-index') }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('user-profile')}}">{{ __('User') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-lg-6 offset-3">
            <!-- Form Basic -->
            @include('includes.admin.form-both')
              <div class="card-body">
              
                <form id="pageForm" action="{{route('admin-user-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                  @csrf

                  <div class="form-group mt-2">
                    <label for="pending_earning">{{ __('Pending Amount') }}</label>
                      <input type="text" class="form-control" name="pending_earning" id="pending_earning" placeholder="{{ __('pending_earning') }}" value="{{round($data->pending_earning,2)}}">
                  </div>

                  <div class="form-group mt-2">
                    <label for="total_earning">{{ __('Total Earning Amount') }}</label>
                      <input type="text" class="form-control" name="total_earning" id="total_earning" placeholder="{{ __('Total Earning Amount') }}" value="{{round($data->total_earning,2)}}">
                  </div>
              
                  <div class="form-group profile_image_view text-center mb-2  {{ $data ? '' : 'd-none'}}">
                      <img src="{{ $data->photo != null ? asset('assets/images/users/'.$data->photo) : asset('assets/images/noimage.png')}}" class="rounded-circle img-fluid " alt="image" width="150">
                  </div>
                  <div class="form-group">
                      <label for="languageimage">{{ __('Image') }}</label>
                      <span class="ml-2">{{ __('(support (jpeg,jpg,png))') }}</span>
                      <div class="custom-file">
                          <input type="file" class="custom-file-input profile_image" name="photo"  value="" accept="image/*">
                         
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
                    <div class="form-group mt-2">
                      <label for="birthday">{{ __('Birthday') }}</label>
                        <input type="date" class="form-control" name="birthday" id="birthday" placeholder="{{ __('Birthday') }}" value="{{$data->birthday}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="gander">{{ __('Gander') }}</label>
                        <select name="gander" id="gander" class="form-control">
                          <option value="Male" {{$data->gander == 'Male' ? 'selected' : ''}}>{{__('Male')}}</option>
                          <option value="Famale" {{$data->gander == 'Famale' ? 'selected' : ''}}>{{__('Famale')}}</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                      <label for="country_field">{{ __('Country') }}</label>
                        <input type="text" class="form-control" name="country" id="country_field" placeholder="{{ __('Country') }}" value="{{$data->country}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="city">{{ __('City') }}</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="{{ __('City') }}" value="{{$data->city}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="state">{{ __('State') }}</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="{{ __('State') }}" value="{{$data->state}}">
                    </div>
                    <div class="form-group mt-2">
                      <label for="zip_code">{{ __('Zip Code') }}</label>
                        <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="{{ __('Zip Code') }}" value="{{$data->zip_code}}">
                    </div> 
                    
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                  </form>
                </div>
            </div>
    </div>
</div>
<input type="hidden" value="1" id="isValue">
@endsection

