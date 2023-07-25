@extends('layouts.load')

@section('content')
<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-faq-store')}}" method="POST">
        @csrf
          <div class="form-group">
            <label for="Category">{{ __('Title') }}</label>
            <input type="text" class="form-control" name="title" required id="title" placeholder="{{ __('Title') }}" >
          </div>
  
           <div class="form-group">
                <label for="area1">{{ __('Details') }}</label>
                 <textarea id="area1" class="form-control nic-edit" name="details"></textarea>
            </div>
          <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
      </div>
  </div>
@endsection
