@extends('layouts.load')

@section('content')


    <div class="col-lg-12">
      <!-- Form Basic -->
        <div class="card-body">
          @include('includes.admin.form-error')  
          <form id="ModalFormSubmit" action="{{route('admin-attrtrem-update',$data->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" class="form-control" name="name" value="{{$data->name}}" id="name" placeholder="{{ __('Name') }}">
            </div>
            <input type="hidden" value="{{$data->hotel_attr_id}}" name="hotel_attr_id">
            <div class="text-center ShowImage mb-4">
                <img class="img-profile" src="{{ $data->image->image ? asset('assets/images/attr-term-image/'.$data->image->image) : asset('assets/images/noimage.png')}}">
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input image"  name="image">
                <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
            </div>
            <div class="form-group">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
          </div>
      </div>
@endsection

