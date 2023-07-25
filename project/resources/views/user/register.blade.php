@extends('layouts.front')

@section('styles')
<link href="{{asset('assets/user/css/login.css')}}" rel="stylesheet">
@endsection

@section('title')
{{__('Register')}} | {{$gs->website_title}}
@endsection
@section('content')

<div class="container login-container">
  <div class="row justify-content-center login-padding-area">
    <div class="col-xl-10 col-lg-12 col-md-9">
      <div class="card shadow-sm my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg-12">
              <div class="login-form">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">{{ ('Register') }}</h1>
                </div>

                <form id="registerform" class="user" action="{{route('user-register-submit')}}" method="POST">@csrf
                  @include('includes.admin.form-login')
                  <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Enter Your Name') }}">
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control" name="phone" placeholder="{{ __('Enter Your Phone') }}">
                  </div>

                  <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="{{ __('Enter Email Address') }}">
                  </div>

                  <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}">
                  </div>

                  @if($gs->is_capcha == 1)
                  <div class="d-flex align-content-center align-items-center">
                    <p><img class="codeimg1" src="{{asset(" assets/images/capcha_code.png")}}" alt=""></p>
                    <i data-href="{{url('contact/refresh_code')}}"
                      class="fas fa-sync-alt pointer refresh_code ml-2"></i>
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control" name="codes" placeholder="{{ __('Enter Code') }}"
                      required="">
                  </div>
                  @endif
                  <input id="authdata" type="hidden" value="{{ __('Authenticating...') }}">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block ">{{ __('Register') }}</button>
                  </div>
                </form>

                <div class="form-group text-center">
                  <p class="m-0"><small>{{__("Already Have an account?")}} <a href="{{route('user.login')}}"
                        class="text-primary">{{__(" Sign Up ")}}</a> </small></p>
                  <p class="m-0"><small>{{__("Forgot Password")}} <a href="{{route('user-forgot')}}"
                        class="text-primary">{{__("Click Here")}}</a> </small></p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script>
  'use strict';
  var mainurl = "{{url('/')}}";
  var gs  = @json($gs);
  var lang  = {
        'check': '{{ __('ADD NEW') }}',
        'sss': '{{ __('Success !') }}',
        'login' : '{{__('Login')}}',
        'processing': '{{ __('Processing') }}',
      };
      
</script>

<script>
  
  $.get($(this).data('href'), function (data, status) {
      $('.codeimg1').attr("src", "" + mainurl + "/assets/images/capcha_code.png?time=" + Math.random());
    });
</script>


<script src="{{asset('assets/user/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/user/js/ruang-admin.min.js')}}"></script>
<script src="{{asset('assets/user/js/myscript.js')}}"></script>
@endsection