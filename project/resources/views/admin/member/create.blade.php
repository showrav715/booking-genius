@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-member-store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}">
        </div>

        <div class="form-group">
            <label for="designation">{{ __('Designation') }}</label>
            <input type="text" class="form-control" name="designation" id="designation" placeholder="{{ __('Designation') }}">
        </div>
        
        <div class="text-center ShowImage mb-4">
            <img class="img-profile" src="{{asset('assets/images/noimage.png')}}" >
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input image"  name="photo">
            <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
        </div>
        <div class="form-group mt-2">
            <label for="message">{{ __('Message') }}</label>
            <textarea type="text" rows="5" class="form-control" name="message" id="message" placeholder="{{ __('Message') }}"></textarea>
        </div>

        <div class="form-group">
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
      </div>
  </div>
@endsection

