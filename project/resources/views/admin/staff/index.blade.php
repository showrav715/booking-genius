@extends('layouts.admin')

@section('content')
<input type="hidden" id="headerdata" value="{{ __('STAFF') }}">
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Staff Manage') }}</h1>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Staff Manage') }}</li>
      </ol>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-header">
            <form action="{{route('admin.bulk.delete')}}" id="bulk-delete" class="d-flex flex-row align-items-center">
              <input type="hidden" name="table" value="admins">
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
            <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
              <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" id="all_select"></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Options') }}</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader">
               <img src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}" alt="">
            </div>
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
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

<input type="hidden" id="isValue" value="1">
@endsection

@section('script')

    <script type="text/javascript">

    $(function ($) {
       "use strict";

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('admin-staff-datatables') }}',
               columns: [
                        { data: 'serial', name: 'serial' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'phone', name: 'phone' },
                        { data: 'role', name: 'role' },
            			      { data: 'action', searchable: false, orderable: false }
                     ],


                language : {
                	processing: '<img class="" src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
			
            });

         $(function() {
        $(".btn-area").append('<div class="col-sm-4 col-md-4 text-right mb-2">'+
        '<a class="btn btn-primary " href="javascript:;" data-href="{{route('admin-staff-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">'+
        '<i class="fas fa-plus"></i> {{ __('Add New Staff') }}'+
        '</a>'+
        '</div>');
      });
  });
</script>

@endsection
