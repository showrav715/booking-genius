
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
	<link rel="shortcut icon" href="{{asset('assets/images/genarel-settings/'.$gs->favicon)}}" type="image/x-icon">
  <title>{{$gs->website_title}}</title>
<link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/css/ruang-admin.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{ ('Login') }}</h1>
                  </div>
                  @include('includes.admin.form-login')
                <form id="loginform" class="user" action="{{route('admin.login.submit')}}" method="POST">@csrf
                    <div class="form-group">
                      <input type="email" class="form-control" name="email" placeholder="{{ __('Enter Email Address') }}">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}">
                    </div>
                    <input id="authdata" type="hidden" value="{{ __('Authenticating...') }}">
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                    </div>
                  </form>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="{{asset('assets/admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/admin/js/ruang-admin.min.js')}}"></script>
<script src="{{asset('assets/admin/js/myscript.js')}}"></script>
<script type="text/javascript">
  var mainurl = "{{url('/')}}";
   var admin_loader = {{ $gs->is_admin_loader }};
   var lang  = {
        'new': '{{ __('ADD NEW') }}',
        'edit': '{{ __('EDIT') }}',
        'update': '{{ __('Status Updated Successfully.') }}',
        'sss': '{{ __('Success !') }}',
    };


</script>
</body>

</html>