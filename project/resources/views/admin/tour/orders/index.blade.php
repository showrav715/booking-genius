
@extends('layouts.admin')

@section('content')

@php
if(Request::path() == 'admin/tour/orders/all'){
    $name = __('All Orders');
    $ajax = 'all';
}elseif(Request::path() == 'admin/tour/orders/pending'){
    $name = __('Pending Orders');
    $ajax = 'Pending';
}else{
    $name = __('Completed Orders');
    $ajax = 'Completed';
}
    
@endphp
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $name }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
        </ol>
    </div>

    <!-- Row -->
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <form action="{{route('admin.bulk.delete')}}" id="bulk-delete" class="d-flex flex-row align-items-center">
                        <input type="hidden" name="table" value="orders">
                        <input type="hidden" name="order_type" value="tour">
                        <input type="hidden" name="ids" id="getId" value="">
                        <div class="form-group">
                            <select class="form-control form-control-sm" name="type">
                                <option value="" selected>{{__('Bulk Actions')}}</option>
                                <option value="delete">{{__('Delete')}}</option>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-sm mb-3 ml-3" disabled class="submit">{{__('Apply')}}</button>
                    </form>
                </div>
                @include('includes.admin.form-both')
                <div class="table-responsive p-3">
                    <table id="geniustable" class="table align-items-center table-flush  dt-responsive" >
                        <thead class="thead-light">
                            <tr>
                                <th><input type="checkbox" id="all_select"></th>
                                <th width="20%">{{ __('Service') }}</th>
                                <th width="25%">{{ __('Customer') }}</th>
                                <th width="10%">{{ __('Total') }}</th>
                                <th width="10%">{{ __('Status') }}</th>
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
               ajax: '{{ route('admin-tour-datatables-orders',$ajax) }}',
               columns: [
                        { data: 'serial', name: 'serial' },
                        { data: 'item_id', name: 'item_id' },
                        { data: 'user_id', name: 'user_id' },
                        { data: 'total',    name: 'total' },
                        { data: 'order_status',    name: 'order_status'},
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

