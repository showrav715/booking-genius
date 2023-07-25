@extends('layouts.load')

@section('content')

<div class="modal-header">
    <h5 class="modal-title">{{__('Booking ID')}}: #{{$data->order_number}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="pills-tone-tab" data-toggle="pill" href="#pills-tone" role="tab" aria-controls="pills-tone" aria-selected="true">
          {{__('Booking Details')}}
      </a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="pills-ttwo-tab" data-toggle="pill" href="#pills-ttwo" role="tab" aria-controls="pills-ttwo" aria-selected="false">
          {{__('Customer Information')}}
      </a>
    </li>
  </ul>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-tone" role="tabpanel" aria-labelledby="pills-tone-tab">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Service Name')}}</span>
                <span>{{$data->car->title}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Booking Status')}}</span>
                @if($data->order_status == 'Pending')
                <span class="badge badge-info">{{__('Pending')}}</span>
                @elseif($data->order_status == 'Processing')
                <span class="badge badge-primary">{{__('Processing')}}</span>
                @elseif($data->order_status == 'Completed')
                <span class="badge badge-success">{{__('Completed')}}</span>
                @else
                <span class="badge badge-danger">{{__('Cancel')}}</span>
                @endif
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Booking Date')}}</span>
                <span>{{$data->created_at->format('d/m/Y')}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Payment Method')}}
                </span>
                <span>
                    {{$data->method}}
                </span>
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Transaction Id')}}
                </span>
                <span>
                    {{$data->txnid}}
                </span>
            </li>
            
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Start date')}}:
                </span>
                <span>{{$data->start_date}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('End date')}}:
                </span>
                <span>{{$data->end_date}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Nights')}}:
                </span>
                <span>{{$data->night}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Car Number')}}:
                </span>
                <span>{{$data->qty}}
                </span>
            </li>
        </ul>
        <br>
   
        @if($data->extra_price)
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <b>{{__('Extra Prices')}}:</b>
                <span></span>
            </li>
            @foreach (explode(',',$data->extra_price) as  $key => $e_price)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{explode(',',$data->extra_name)[$key]}} <small>({{str_replace('_',' ',explode(',',$data->extra_type)[$key])}}) </small> :
                    </span>
                    <span>{{$data->currency_sign }}{{round($e_price * $data->currency_value,2)}}
                    </span>
                </li>
            @endforeach
        </ul>
        
        @endif

        @if($data->summery)
        <li class="list-group-item d-flex justify-content-between">
            <span>{{('Summery')}}:
            </span>
            <span>{{$data->summery}}</span>
        </li>
        @endif
       
          <ul class="list-group">
              @if($data->service_charge)
            <li class="list-group-item d-flex justify-content-between">
                <b>{{__('Service Fee')}}:
                </b>
                <b>{{$data->currency_sign}} {{round($data->service_charge * $data->currency_value,2)}}
                </b>
            </li>
            @endif
            <li class="list-group-item d-flex justify-content-between">
                <b>{{__('Total')}}:
                </b>
                <b>{{$data->currency_sign}} {{round($data->total * $data->currency_value,2)}}
                </b>
            </li>

            
        </ul>
    </div>
    <div class="tab-pane fade" id="pills-ttwo" role="tabpanel" aria-labelledby="pills-ttwo-tab">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Customer Name')}}</span>
                <span>{{$data->name}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Customer Email')}}</span>
                <span>{{$data->email}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Customer Number')}}
                </span>
                <span>{{$data->number}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{__('Customer Address')}}</span>
                <span>
                    <span>{{$data->address}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>{{('Customer City')}}:
                </span>
                <span>{{$data->city}}
                </span>
            </li>
            @if($data->state)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{('Customer State')}}:
                </span>
                <span>
                    {{$data->state}}
                </span>
            </li>
            @endif
            <li class="list-group-item d-flex justify-content-between">
                <span>{{('Costomer Country')}}:
                </span>
                <span>{{$data->country}}
                </span>
            </li>
            @if($data->zip_code)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{('Zip Code')}}:
                </span>
                <span>{{$data->zip_code}}</span>
            </li>
            @endif
        </ul>
    </div>
  </div>
@endsection