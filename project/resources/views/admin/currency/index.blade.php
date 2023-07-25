@extends('layouts.admin')

@section('content')
<input type="hidden" id="headerdata" value="{{ __('CURRENCY') }}">
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Currencies') }}</h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Currencies') }}</li>
      </ol>
  </div>

  <!-- Row -->
  <div class="row">
      <!-- Datatables -->
      <div class="col-lg-12">
          <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<div class="btn-group mb-3">
						<button type="button" class="btn dropdown-toggle {{ $gs->is_currency == 1 ? 'btn-success' : 'btn-danger' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ $gs->is_currency == 1 ? __('Activated') : __('Deactivated') }}
						</button>
						<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
							<a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','1,is_currency')}}">{{ __('Activated') }}</a>
							<a class="dropdown-item gs-status-check cursor-pointer" data-href="{{route('admin.gs.status','0,is_currency')}}">{{ __('Deactivated') }}</a>
						</div>
					</div>
				
              </div>
              @include('includes.admin.form-both')
              <div class="table-responsive p-3">
                  <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                      <thead class="thead-light">
                          <tr>
							<th>{{ __('Name') }}</th>
							<th>{{ __('Sign') }}</th>
							<th>{{ __('Value') }}</th>
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
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
          <div class="submit-loader">
              <img src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}" alt="">
          </div>
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalScrollableTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
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
       
          <div class="modal-body">
            <p class="text-center">{{__("You are about to delete this Currency.")}}</p>
            <p class="text-center">{{ __("Do you want to proceed?") }}</p>
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
			   ajax: '{{ route('admin-currency-datatables') }}',
               columns: [
                        { data: 'name', name: 'name' },
                        { data: 'sign', name: 'sign' },
                        { data: 'value', name: 'value' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],

                language : {
                	processing: '<img class="" src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
			
            });

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 col-md-4 text-right mb-2">'+
        '<a class="btn btn-primary " href="javascript:;" data-href="{{route('admin-currency-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">'+
        '<i class="fas fa-plus"></i> {{ __('Add New Currency') }}'+
        '</a>'+
        '</div>');
      });
    });
</script>

@endsection
