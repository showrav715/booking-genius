
@extends('layouts.user')

@section('content')

@php
if(Request::path() == 'user/hotel/orders/all'){
    $name = __('All Orders');
    $ajax = 'all';
}elseif(Request::path() == 'user/hotel/orders/pending'){
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
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
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
                                <th width="10%">{{ __('Status') }}</th>
                                <th width="10%">{{ __('P Method') }}</th>
                                <th width="10%">{{ __('Book Time') }}</th>
                                <th width="10%">{{ __('Action') }}</th>
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

  {{-- DELETE MODAL --}}
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
{{-- DELETE MODAL ENDS --}}

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
               ajax: '{{ route('user-hotel-datatables-orders',$ajax) }}',
               columns: [
                        { data: 'item_id', name: 'item_id' },
                        { data: 'user_id', name: 'user_id' },
                        { data: 'total',    name: 'total' },
                        { data: 'order_status',    name: 'order_status'},
                        { data: 'method',    name: 'method'},
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

