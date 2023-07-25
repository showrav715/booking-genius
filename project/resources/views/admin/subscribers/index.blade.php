@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">{{ __('Subscribers') }}</h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Subscribers') }}</li>
      </ol>
  </div>

  <!-- Row -->
  <div class="row">
      <!-- Datatables -->
      <div class="col-lg-12">
          <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              </div>
              @include('includes.admin.form-success')
              <div class="table-responsive p-3">
                  <table id="geniustable" class="table align-items-center table-flush  dt-responsive" id="dataTable">
                      <thead class="thead-light">
                          <tr>
                              <th>{{ __('#Sl') }}</th>
                              <th>{{ __('Email') }}</th>
                          </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection

@section('script')

    <script type="text/javascript">
    $(function ($) {
       "use strict";

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('admin-subs-datatables') }}',
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'email', name: 'email' },
                     ],
                language : {
                	processing: '<img src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
            });

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 col-md-4 text-right mb-2">'+
        	'<a class="btn btn-primary" href="{{route('admin-subs-download')}}">'+
          '<i class="fa fa-download"></i> {{ __('Download') }}'+
          '</a>'+
          '</div>');
      });
    });
</script>

@endsection
