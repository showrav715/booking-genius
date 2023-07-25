@extends('layouts.load')

@section('content')

<div class="col-lg-12">
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-withdraw-method-store')}}" method="POST">
        @csrf
          <div class="form-group">
            <label for="method">{{ __('Enter Method Name') }}</label>
          <input type="text" class="form-control" name="name" value="" id="method" placeholder="{{ __('Enter Method Name') }}">
          </div>
  
          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>
@endsection