
@extends('layouts.user')

@section('content')


<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Tour Order History') }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Tour Order History') }}</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                </div>
                @include('includes.admin.form-both')
                <div class="table-responsive p-3">
                    <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th width="20%">{{ __('Service') }}</th>
                                <th width="20%">{{ __('Customer') }}</th>
                                <th width="20%">{{ __('Total') }}</th>
                                <th width="10%">{{ __('Book Time') }}</th>
                                <th width="15%">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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


  <div class="modal fade" id="confirm-book-cancel" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ __('Confirm Cancelation') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">{{ __('Are you sure?') }}.</p>
                <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                
                <form action="{{route('user.order.cancel')}}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="">
                    <input type="hidden" name="type" value="tour">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="method">{{ __('Select Account') }}</label>
                            <select name="method" class="form-control" id="method" required>
                                <option value="" selected disabled>{{__('Select Method')}}</option>
                               @foreach (DB::table('withdraw_methods')->whereStatus(1)->get() as $method)
                                   <option value="{{$method->name}}">{{$method->name}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="details">{{ __('Enter Account Information') }}</label>
                               <textarea name="details" class="form-control" id="details" required placeholder="{{__('Enter Account Information')}}"></textarea>
                            </div>
                        </div>
                        
                    </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Back') }}</button>
                <button type="submit" class="btn btn-danger btn-ok">{{ __('Order Cancel') }}</button>
            </div>
        </form>
        </div>
    </div>
</div>

<input type="hidden" value="1" id="isValue">
@endsection

@section('script')

    <script type="text/javascript">
    $(function ($) {
        "use strict";
		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('user-tour-datatables-orders-history') }}',
               columns: [
                        { data: 'item_id', name: 'item_id' },
                        { data: 'user_id', name: 'user_id' },
                        { data: 'total',    name: 'total' },
                        { data: 'created_at',name: 'created_at' },
            			{ data: 'action', searchable: false, orderable: false }
                     ],

                language : {
                	processing: '<img class="" src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
			
            });
    });

</script>

@endsection

