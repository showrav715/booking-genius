
@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Cancel Booking') }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Cancel Booking') }}</li>
        </ol>
    </div>

    <!-- Row -->
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
              
                @include('includes.admin.form-both')
                <div class="table-responsive p-3">
                    <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('User Email') }}</th>
                                <th>{{ __('Booking Number') }}</th>
                                <th>{{ __('Method') }}</th>
                                <th>{{ __('Details') }}</th>
                                <th>{{ __('Status') }}</th>
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
               ajax: '{{ route('admin-order-cancel-datatables') }}',
               columns: [
                        { data: 'user_id', name: 'user_id' },
                        { data: 'order_id', name: 'order_id' },
                        { data: 'method', name: 'method' },
                        { data: 'details', name: 'details' },
                        { data: 'status', name: 'status' },
            			
                     ],

                language : {
                	processing: '<img class="" src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
			
            });
 });
</script>

@endsection

