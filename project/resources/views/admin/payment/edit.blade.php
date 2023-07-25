@extends('layouts.load')

@section('content')

<div class="col-lg-12">
  <!-- Form Basic -->
    <div class="card-body">
      @include('includes.admin.form-error')  
      <form id="ModalFormSubmit" action="{{route('admin-payment-update',$data->id)}}" method="POST">
        @csrf

        @if($data->type == 'automatic')

          <div class="form-group">
            <label for="Category">{{ __('Name') }}</label>
            <input type="text" class="form-control" name="name" value="{{$data->name}}" id="" placeholder="{{ __('Name') }}">
          </div>

          @if($data->information != null)
          @foreach($data->convertAutoData() as $pkey => $pdata)

          @if($pkey == 'sandbox_check')

          <div class="custom-control custom-checkbox mb-2">
            <input type="checkbox" class="custom-control-input" id="customCheck1" name="pkey[{{ __($pkey) }}]" value="1" {{ $pdata == 1 ? "checked":"" }}>
            <label class="custom-control-label" for="customCheck1">{{ __( $data->name.' '.ucwords(str_replace('_',' ',$pkey)) ) }} *</label>
          </div>

          @else
          <div class="form-group">
            <label for="">{{ __( $data->name.' '.ucwords(str_replace('_',' ',$pkey)) ) }} *</label>
            <input type="text" class="form-control" name="pkey[{{ __($pkey) }}]" placeholder="{{ __( $data->name.' '.ucwords(str_replace('_',' ',$pkey)) ) }}" value="{{ $pdata }}" required="">
          </div>
          @endif
          @endforeach
          <div class="form-group">
            <label for="">{{ $data->name.' '.__('Currency') }} *</label>
            <select name="" class="form-control">
              @foreach(DB::table('currencies')->get() as $dcurr)
                <option value="{{ $dcurr->id }}" {{ $dcurr->id == $data->currency_id ? 'selected' : '' }}>
                  {{ $dcurr->name }}
                </option>
              @endforeach
          </select>
          </div>



          @endif
          @else
          <div class="form-group">
            <label for="Category">{{ __('Name') }}</label>
          <input type="text" class="form-control" name="title" value="{{$data->title}}" placeholder="{{ __('Name') }}">
          </div>
       
          @if($data->keyword == null)
          <div class="form-group">
            <label for="area1">{{ __('Description') }}</label>
             <textarea id="area1" class="form-control" name="details">{{$data->details}}</textarea>
        </div>

        @endif
        @endif

          <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </form>
      </div>
  </div>


@endsection