@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin.country.store')}}" method="POST">
        @csrf


        <div class="text-center ShowImage mb-2">
            <img class="img-profile" src="{{asset('assets/images/noimage.png')}}" >
        </div>

        <div class="custom-file mb-2">
            <input type="file" class="custom-file-input image"  name="image">
            <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
        </div>

          <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
          <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('Title') }}">
          </div>
  
        <div class="form-group">
        <label for="country_text">{{ __('Country') }}</label>
          <input type="text" class="form-control" name="country" id="country_text"  placeholder="{{ __('Country') }}">
        </div>

          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>
@endsection