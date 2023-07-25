@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-spaceattr-store')}}" method="POST">
        @csrf
          <div class="form-group">
            <label for="name">{{ __('Attribute Name') }}</label>
          <input type="text" class="form-control" name="name" value="" id="name" placeholder="{{ __('Attribute Name') }}">
          </div>
          <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
      </div>
  </div>
@endsection