@extends('layouts.front')
@section('title')
   Error 
@endsection
@section('content')
<div class="breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="pagetitle">
          {{ __('Error') }}
        </h1>
        <ul class="pages">
          <li>
          <a href="{{route('front.index')}}">
              {{ __('Home') }}
            </a>
          </li>
          <li class="active">
            <a href="javascript:;">
              {{ __('Error') }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumb Area End -->

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
          <img src="{{$gs->error_photo ? asset('assets/images/genarel-settings/'.$gs->error_photo) : ''}}" alt="">
              {!! $gs->error_title !!}
              {!! $gs->error_text !!}
            <a class="mybtn1 pt-3" href="{{ route('front.index') }}">{{ __('Back Home') }}</a>
          </div>
        </div>
      </div>
    </div>


@endsection