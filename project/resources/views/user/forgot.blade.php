@extends('layouts.front')

@section('title')
	{{__('Forgot')}} | {{$gs->website_title}}
@endsection
@section('styles')
  <link href="{{asset('assets/user/css/login.css')}}" rel="stylesheet">
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
                  <h1 class="h4 text-gray-900 mb-4">{{ ('Forgot Your Password') }}</h1>
                </div>
                <form id="forgotform" class="user" action="{{route('user-forgot-submit')}}" method="POST">@csrf
                  @include('includes.admin.form-login')
                  <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="{{ __('Enter Email Address') }}">
                  </div>
                
                
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Submit') }}</button>
                  </div>
                  <input class="authdata" type="hidden" value="{{ __('Checking') }}...">
                </form>

                <div class="form-group text-center">
                  <p class="m-0"><small>{{__("Login")}} <a href="{{route('user.login')}}" class="text-primary">{{__("Click Here")}}</a>  </small></p>
                    <p class="m-0"><small>{{__("Don't have an account?")}} <a href="{{route('user-register-form')}}" class="text-primary">{{__(" Sign Up ")}}</a>  </small></p>
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