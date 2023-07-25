@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
    <form id="ModalFormSubmit" action="{{route('admin-tour-cat-update',$data->id)}}" method="POST">
      @csrf
        <div class="form-group">
          <label for="Category">{{ __('Category Name') }}</label>
        <input type="text" class="form-control" name="name" value="{{$data->name}}" id="Category" placeholder="{{ __('Category Name') }}">
        </div>
        <div class="form-group">
          <label for="slug">{{ __('Slug') }}</label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{$data->slug}}" placeholder="{{ __('Slug') }}">
        </div>
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
      </form>
    </div>
</div>
@endsection