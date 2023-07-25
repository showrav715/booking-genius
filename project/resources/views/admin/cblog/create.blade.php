@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-cblog-store')}}" method="POST">
        @csrf
          <div class="form-group">
            <label for="Category">{{ __('Category Name') }}</label>
          <input type="text" class="form-control" name="name" value="" id="Category" placeholder="{{ __('Category Name') }}">
          </div>
  
          <div class="form-group ShowLanguageImage d-none">
            <img src="" alt="image" width="150">
          </div>

          <div class="form-group">
            <label for="slug">{{ __('Slug') }}</label>
          <input type="text" class="form-control" name="slug" id="slug" value="" placeholder="{{ __('Slug') }}">
          </div>
          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>
@endsection