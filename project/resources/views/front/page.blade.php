@extends('layouts.front')
@section('title')
    {{ $data->title }} | {{ $gs->website_title }}
@endsection

@if($data->meta_tag != null || $data->meta_description != null)
@section('meta_content')
<meta property="og:title" content="{{$data->title}}" />
<meta property="og:description" content="{{ $data->meta_description != null ? $data->meta_description : strip_tags($data->meta_description) }}" />

<meta name="keywords" content="{{ $data->meta_tag }}">
<meta name="description" content="{{ $data->meta_description }}">

@endsection
@endif

@section('content')

 <!--Main Breadcrumb Area Start -->
 <div class="main-breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="pagetitle">
          {{$data->title}}
        </h1>
        <ul class="pages">
          <li>
            <a href="{{route('front.index')}}">
              {{__('Home')}}
            </a>
          </li>
          <li class="active">
            <a href="{{route('front.pages',$data->slug)}}">
              {{$data->title}}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--Main Breadcrumb Area End -->


    <section class="about">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 py-5">
              <div class="about-info">
                  {!! $data->details !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  
@endsection


