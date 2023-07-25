@extends('layouts.front')

@section('title')
{{ ('Success | ') }}{{ $gs->website_title }}
@endsection

@section('content')
    <!-- Breadcrumb Area Start -->
	<div class="breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="pagetitle">
						{{ __('Payment Success') }}
					</h1>
					<ul class="pages">
						<li>
							<a href="{{ route('front.index') }}">
								{{ __('Home') }}
							</a>
						</li>
						<li class="active">
							<a href="{{ Request::url() }}">
							{{ __('Payment Success') }}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Breadcrumb Area End -->



<section class="thankyou">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-11">
          <div class="content">
            <div class="icon">
                <i class="far fa-check-circle"></i>
            </div>
            <h4 class="heading">
                 {{ $gs->order_title }}
                
            </h4>
            <p class="text">
                {{ $gs->order_text }}
            </p>
            <a href="{{ route('front.index') }}" class="link">{{ __('Get Back To Our Homepage') }}</a>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection