
<!-- AJAX Js-->
<script type="text/javascript">
	'use strict';			
    var mainurl = "{{url('/')}}";
    var admin_loader = {{ $gs->is_admin_loader }};
    var lang  = {
          'new': '{{ __('ADD NEW') }}',
          'edit': '{{ __('EDIT') }}',
          'details': '{{ __('DETAILS') }}',
          'update': '{{ __('Status Updated Successfully.') }}',
          'sss': '{{ __('Success !') }}',
          'active': '{{ __('Activated') }}',
          'deactive': '{{ __('Deactivated') }}',
          'loading': '{{ __('Please wait Data Processing...') }}',
          'submit': '{{ __('Submit') }}',
          'enter_name': '{{ __('Enter Name') }}',
          'enter_price': '{{ __('Enter Price') }}',
          'per_day': '{{ __('Per Day') }}',
          'per_month': '{{ __('Per Month') }}',
          'per_year': '{{ __('Per Year') }}',
          'one_time': '{{ __('One Time') }}',
          'enter_title': '{{ __('Enter Title') }}',
          'enter_content': '{{ __('Enter Content') }}',
          'extra_price_name' : '{{__('Enter Name')}}',
          'extra_price' : '{{__('Enter Price')}}',
          'policy_title' : '{{__('Enter Title')}}',
          'policy_content' : '{{__('Enter Content')}}',
      };
      
</script>
<script src="{{asset('assets/admin/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery-migrate-3.3.2.js')}}"></script>
<script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<script src="{{asset('assets/admin/js/datepicker.js')}}"></script>
<script src="{{asset('assets/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/datatables/dataTables.bootstrap4.js')}}"></script>

<script src="{{asset('assets/admin/js/select-2.js')}}"></script>
<script src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
<script src="{{asset('assets/admin/js/ruang-admin.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{asset('assets/admin/js/notify.js')}}"></script>
<script src="{{asset('assets/admin/js/tagify.min.js')}}"></script>
<script src="{{asset('assets/admin/js/tagify.js')}}"></script>
<script src="{{asset('assets/admin/vendor/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/admin/js/load.js')}}"></script>
<script src="{{asset('assets/admin/js/custom.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery-form.js')}}"></script>
<script src="{{asset('assets/admin/js/myscript.js')}}"></script>



