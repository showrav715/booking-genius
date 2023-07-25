@extends('layouts.front')

@section('styles')
  <link href="{{asset('assets/user/css/login.css')}}" rel="stylesheet">
@endsection

@section('title')
	{{__('Login')}} | {{$gs->website_title}}
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
                  <h1 class="h4 text-gray-900 mb-4">{{ ('Login') }}</h1>
                </div>
                <form id="loginform" class="user" action="{{route('user.login.submit')}}" method="POST">@csrf
                  @include('includes.admin.form-login')
                  <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="{{ __('Enter Email Address') }}">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                      <input type="checkbox" name="remember" id="rp" class="custom-control-input" id="customCheck">
                      <label class="custom-control-label" for="rp">
                        {{ __('Remember Me') }}</label>
                    </div>
                  </div>
                  <input id="authdata" type="hidden" value="{{ __('Authenticating...') }}">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                  </div>
                </form>

                <div class="form-group text-center">
                    <p class="m-0"><small>{{__("Don't have an account?")}} <a href="{{route('user-register-form')}}" class="text-primary">{{__(" Sign Up ")}}</a>  </small></p>
                    <p class="m-0"><small>{{__("Forgot Password")}} <a href="{{route('user-forgot')}}" class="text-primary">{{__("Click Here")}}</a>  </small></p>
                </div>
                <div class="text-center login-areaa">
                  <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 offset-lg-3 offset-md-3">
                      @if(DB::table('socialsettings')->find(1)->f_check == 1 || DB::table('socialsettings')->find(1)->g_check == 1)
                        <div class="social-area">
                          <ul class="social-links">
                            @if(DB::table('socialsettings')->find(1)->f_check == 1)
                            <li>
                              <a href="{{ route('social-provider','facebook') }}" class="facebook">
                                <i class="fab fa-facebook-f"></i> {{ __('Facebook') }}
                              </a>
                            </li>
                            @endif
                            @if(DB::table('socialsettings')->find(1)->g_check == 1)
                            <li>
                              <a href="{{ route('social-provider','google') }}" class="google">
                                <i class="fab fa-google-plus-g"></i> {{ __('Google') }}
                              </a>
                            </li>
                            @endif
                          </ul>
                        </div>
                        @endif
                    </div>
                  </div>

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
      };
</script>
    
<script src="{{asset('assets/user/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/user/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/user/js/ruang-admin.min.js')}}"></script>
<script src="{{asset('assets/user/js/myscript.js')}}"></script>  
@endsection