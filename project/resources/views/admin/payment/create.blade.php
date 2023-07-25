@extends('layouts.load')

@section('content')

<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-payment-create')}}" method="POST">
        @csrf
          <div class="form-group">
            <label for="Category">{{ __('Name') }}</label>
          <input type="text" class="form-control" name="title" value="" placeholder="{{ __('Name') }}">
          </div>
  
          <div class="form-group">
            <label for="area1">{{ __('Description') }}</label>
             <textarea id="area1" class="form-control" name="details"></textarea>
        </div>

          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>


@endsection