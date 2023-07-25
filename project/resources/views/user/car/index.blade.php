
@extends('layouts.user')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Cars') }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Cars') }}</li>
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
          
            <div class="modal-body">
                <p class="text-center">{{ __('Are you sure?') }}.</p>
                <p class="text-center">{{ __('Do you want to proceed?') }}</p>
            </div>
           
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
               ajax: '{{ route('user-car-datatables') }}',
               columns: [
                        { data: 'title', name: 'title' },
                        { data: 'location', name: 'location' },
                        { data: 'main_price', name: 'main_price' },
                        { data: 'status', name: 'status' },
            			{ data: 'action', searchable: false, orderable: false }
                     ],

                language : {
                	processing: '<img src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
			
            });

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 col-md-4 text-right mb-2">'+
        '<a class="btn btn-primary " href="{{route('user-car-create')}}" >'+
        '<i class="fas fa-plus"></i> {{ __('Add New Car') }}'+
        '</a>'+
        '</div>');
      });

    });

</script>

@endsection

