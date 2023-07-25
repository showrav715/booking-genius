@extends('layouts.admin')

@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 mb-0 text-gray-800">{{__('Dashboard')}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">{{__('Dashboard')}}</li>
    </ol>
</div>

<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 bg-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-white mb-1">{{ __('Total Hotel') }}</div>
                    <div class="h5 mb-0 font-weight-bold text-white">{{App\Models\Hotel::count()}}</div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hotel fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 bg-success">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-white mb-1">{{ __('Total Tour') }}</div>
                        <div class="h5 mb-0 font-weight-bold text-white">{{App\Models\TourModel::count()}}</div>

                    </div>
                    <div class="col-auto">
                        <i class="fab fa-tripadvisor fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 bg-danger ">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-white mb-1">{{ __('Total Space') }}</div>
                    <div class="h5 mb-0 font-weight-bold text-white">{{App\Models\Space::count()}}</div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-home fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 bg-secondary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-white mb-1">{{ __('Total Car') }}</div>
                    <div class="h5 mb-0 font-weight-bold text-white">{{App\Models\Car::count()}}</div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-car fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


  <!-- Datatables -->
  <div class="col-lg-12">
    <div class="card mb-4">
        
        @include('includes.admin.form-both')
        <div class="table-responsive p-3">
            <h3 class="mb-3">
                {{__('Recent Hotel Booking')}}
            </h3>
            <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">{{ __('Service') }}</th>
                        <th width="25%">{{ __('Customer') }}</th>
                        <th width="10%">{{ __('Total') }}</th>
                        <th width="10%">{{ __('Book Time') }}</th>
                        <th width="15%">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @if($hotels->count() > 0)
                    @foreach ($hotels as $hotel)
                    <tr>
                        <td>{{$hotel->hotel->title}}</td>
                        <td>
                            <ul class="list-unstyled">
                                <li> <b>{{__('Name:')}}</b>{{$hotel->name}}</li>
                                <li><b>{{__('Email:')}}</b>{{$hotel->email}}</li>
                                <li><b>{{__('Number:')}}</b>{{$hotel->number}}</li>
                                <li><b>{{__('City:')}}</b>{{$hotel->city}}</li>
                            </ul>
                        </td>
                        <td>
                            {{round($hotel->total * $hotel->currency_value,2)}}
                        </td>
                        <td>
                            {{$hotel->created_at->format('d/m/Y')}}
                        </td>
                        <td>
                            <div class="action-list">
                                <a href="{{route('admin.hotel.order.details',$hotel->id)}}"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                                   {{__('Details')}}
                                </a>
                            </div>
                        </td>
                    </tr> 
                    @endforeach
                   @else
                        <tr>
                            <td>
                                {{__('No Booking')}}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

  <!-- Datatables -->
  <div class="col-lg-12">
    <div class="card mb-4">
        
        @include('includes.admin.form-both')
        <div class="table-responsive p-3">
            <h3 class="mb-3">
                {{__('Recent Car Booking')}}
            </h3>
            <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">{{ __('Service') }}</th>
                        <th width="25%">{{ __('Customer') }}</th>
                        <th width="10%">{{ __('Total') }}</th>
                        <th width="10%">{{ __('Book Time') }}</th>
                        <th width="15%">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($cars->count() > 0)
                    @foreach ($cars as $car)
                    <tr>
                        <td>{{$car->car->title}}</td>
                        <td>
                            <ul class="list-unstyled">
                                <li> <b>{{__('Name:')}}</b>{{$car->name}}</li>
                                <li><b>{{__('Email:')}}</b>{{$car->email}}</li>
                                <li><b>{{__('Number:')}}</b>{{$car->number}}</li>
                                <li><b>{{__('City:')}}</b>{{$car->city}}</li>
                            </ul>
                        </td>
                        <td>
                            {{round($car->total * $car->currency_value,2)}}
                        </td>
                        <td>
                            {{$car->created_at->format('d/m/Y')}}
                        </td>
                        <td>
                            <div class="action-list">
                                <a href="{{route('admin.car.order.details',$car->id)}}"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                                   {{__('Details')}}
                                </a>
                            </div>
                        </td>
                    </tr> 
                    @endforeach
                    @else
                    <tr>
                        <td>
                            {{__('No Booking')}}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="col-lg-12">
    <div class="card mb-4">
        
        @include('includes.admin.form-both')
        <div class="table-responsive p-3">
            <h3 class="mb-3">
                {{__('Recent Space Booking')}}
            </h3>
            <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">{{ __('Service') }}</th>
                        <th width="25%">{{ __('Customer') }}</th>
                        <th width="10%">{{ __('Total') }}</th>
                        <th width="10%">{{ __('Book Time') }}</th>
                        <th width="15%">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($spaces->count() > 0)
                    @foreach ($spaces as $space)
                    <tr>
                        <td>{{$space->space->title}}</td>
                        <td>
                            <ul class="list-unstyled">
                                <li> <b>{{__('Name:')}}</b>{{$space->name}}</li>
                                <li><b>{{__('Email:')}}</b>{{$space->email}}</li>
                                <li><b>{{__('Number:')}}</b>{{$space->number}}</li>
                                <li><b>{{__('City:')}}</b>{{$space->city}}</li>
                            </ul>
                        </td>
                        <td>
                            {{round($space->total * $space->currency_value,2)}}
                        </td>
                        <td>
                            {{$space->created_at->format('d/m/Y')}}
                        </td>
                        <td>
                            <div class="action-list">
                                <a href="{{route('admin.space.order.details',$space->id)}}"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                                   {{__('Details')}}
                                </a>
                            </div>
                        </td>
                    </tr> 
                    @endforeach
                    @else
                        <tr>
                            <td>
                               {{__('No Booking')}}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="col-lg-12">
    <div class="card mb-4">
        
        @include('includes.admin.form-both')
        <div class="table-responsive p-3">
            <h3 class="mb-3">
                {{__('Recent Tour Booking')}}
            </h3>
            <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">{{ __('Service') }}</th>
                        <th width="25%">{{ __('Customer') }}</th>
                        <th width="10%">{{ __('Total') }}</th>
                        <th width="10%">{{ __('Book Time') }}</th>
                        <th width="15%">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tours->count() > 0)
                    @foreach ($tours as $tour)
                    <tr>
                        <td>{{$tour->tour->title}}</td>
                        <td>
                            <ul class="list-unstyled">
                                <li> <b>{{__('Name:')}}</b>{{$tour->name}}</li>
                                <li><b>{{__('Email:')}}</b>{{$tour->email}}</li>
                                <li><b>{{__('Number:')}}</b>{{$tour->number}}</li>
                                <li><b>{{__('City:')}}</b>{{$tour->city}}</li>
                            </ul>
                        </td>
                        <td>
                            {{round($tour->total * $tour->currency_value,2)}}
                        </td>
                        <td>
                            {{$tour->created_at->format('d/m/Y')}}
                        </td>
                        <td>
                            <div class="action-list">
                                <a href="{{route('admin.tour.order.details',$tour->id)}}"  class="btn btn-primary btn-sm mr-2 order_details" data-toggle="modal" data-target="#viewDetails">
                                   {{__('Details')}}
                                </a>
                            </div>
                        </td>
                    </tr> 
                    @endforeach
                    @else
                        <tr>
                            <td>
                                {{__('No Booking')}}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!--Row-->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">{{ __('Are you sure?') }}.</p>
                <p class="text-center">{{ __('Do you want to proceed?') }}</p>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="viewDetails" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered dialog modal-lg">
      <div class="modal-content" id="show_order">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
@endsection

