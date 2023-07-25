@extends('layouts.load')

@section('content')


<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin.state.update',$data->id)}}" method="POST">
        @csrf

        <div class="form-group">
            <label for="country">{{ __('Country') }}</label>
             <select class="form-control form-control-sm" name="country_id">
                 <option value="" selected>{{__('Select Country')}}</option>
                 @foreach ($countrys as $country)
                     <option value="{{$country->id}}" {{$data->country_id == $country->id ? 'selected' : ''}}>{{$country->country}}</option>
                 @endforeach
             </select>
        </div>

          <div class="form-group">
            <label for="state">{{ __('State') }}</label>
          <input type="text" class="form-control" name="state"  value="{{$data->state}}" id="state" placeholder="{{ __('State') }}">
          </div>
  
          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>
@endsection