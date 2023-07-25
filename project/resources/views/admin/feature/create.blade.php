@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')
      <form id="ModalFormSubmit" action="{{route('admin-slider-store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('Title') }}</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('title') }}">
        </div>

        <div class="form-group">
          <label for="details">{{ __('Details') }}</label>
          <input type="text" class="form-control" name="details" id="details" placeholder="{{ __('Details') }}">
      </div>

        <div class="text-center ShowImage mb-4">
            <img class="img-profile" src="{{ asset('assets/images/noimage.png')}}" >
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input image"  name="photo">
            <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
        </div>
        <div class="form-group">
            <label for="name">{{ __('Button Name') }}</label>
            <input type="text" class="form-control" name="button_name" id="button_name" placeholder="{{ __('Button Name') }}">
        </div>
        <div class="form-group">
            <label for="name">{{ __('Button Link') }}</label>
            <input type="text" class="form-control" name="button_link" id="button_link" placeholder="{{ __('Button Link') }}">
        </div>

        <div class="form-group">
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
      </div>
  </div>
@endsection

