@extends('layouts.load')

@section('content')

<div class="col-lg-12">
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-currency-create')}}" method="POST">
        @csrf
          <div class="form-group">
            <label for="Category">{{ __('Enter Currency Name') }}</label>
          <input type="text" class="form-control" name="name" value="" id="Category" placeholder="{{ __('Enter Currency Name') }}">
          </div>
  
         
          <div class="form-group">
            <label for="sign">{{ __('Enter Currency Sign') }}</label>
            <input type="text" class="form-control" name="sign" id="sign" value="" placeholder="{{ __('Enter Currency Sign') }}">
          </div>

          <div class="form-group">
            <label for="value">{{ __('Enter Currency Value') }}</label>
            <input type="text" class="form-control" name="value" id="value" value="" placeholder="{{ __('Enter Currency Value') }}">
          </div>

          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>
@endsection