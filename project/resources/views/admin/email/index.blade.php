
@extends('layouts.admin')

@section('content')
<div class="container-fluid" id="container-wrapper">
  <input type="hidden" id="headerdata" value="{{ __('EMAIL TEMPLATES') }}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Email Templates') }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Email Settings') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Email Templates') }}</li>
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
                              <th>{{ __('Email Type') }}</th>
                              <th>{{ __('Email Subject') }}</th>
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
  <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
        <div class="submit-loader">
           <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
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
              <p class="text-center">{{ __('You are about to delete this Email. Everything will be deleted under this Email.') }}</p>
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
               ajax: '{{ route('admin-mail-datatables') }}',
               columns: [
                        {data: 'email_type', name: 'email_type' },
                        { data: 'email_subject', name: 'email_subject' },
                        { data: 'action', searchable: false, orderable: false }
                     ],
                language : {
                	processing: '<img class="" src="{{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}">'
                },
			
            });
  });
</script>

@endsection

