
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	@yield('meta_content')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title')</title>

	<!-- favicon -->
	<link rel="shortcut icon" href="{{asset('assets/images/genarel-settings/'.$gs->favicon)}}" type="image/x-icon">
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
	<!-- Plugin css -->
	<link rel="stylesheet" href="{{asset('assets/front/css/plugin.css')}}">

	<link rel="stylesheet" href="{{asset('assets/front/css/pignose.calender.css')}}">
	<!-- stylesheet -->
	<link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
	@yield('styles')

    @if($site_lang->rtl == 1)
        <link rel="stylesheet" href="{{asset('assets/front/css/rtl.css')}}">
    @endif

	@if(!empty($seo->google_analytics))
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() {
				dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', '{{ $seo->google_analytics }}');
	</script>
	@endif

	@if(!empty($seo->facebook_pixel))
	    <script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '{{ $seo->facebook_pixel }}');
			fbq('track', 'PageView');
		  </script>
		  <noscript>
			<img height="1" width="1" style="display:none"
				 src="https://www.facebook.com/tr?id={{ $seo->facebook_pixel }}&ev=PageView&noscript=1"/>
		  </noscript>
	@endif

</head>

<body>



<!-- preloader area start -->
	@if($gs->is_website_loader == 1)
		<div class="preloader" id="preloader">
			<img src="{{asset('assets/images/genarel-settings/'.$gs->website_loader)}}" alt="">
		</div>
	@endif
<!-- preloader area end -->

	<!--Main-Menu Area Start-->
	<div class="mainmenu-area">
		<!-- Top Header Area Start -->
		<div class="top-header">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="content">
							<div class="left-content">
								
								<div class="language-selector">
									<select name="language" class="language" id="language_setup" data-target="{{route('front.language.setup')}}">
										@foreach (App\Models\Language::get() as $language)
										<option value="{{$language->id}}" {{Session::has('language') && Session::get('language') == $language->id     ? 'selected' : '' }}  >{{$language->language}}</option>
										@endforeach
									</select>
								</div>
								
                                
								@if ($gs->is_currency != 0)
                                <div class="language-selector">
                                    <select name="currency"  class="language" id="currency_setup" data-target="{{route('front.currency.setup')}}">
                                        @foreach (App\Models\Currency::get() as $currency)
                                        <option value="{{$currency->id}}" {{Session::has('currency') && Session::get('currency') == $currency->id  ? 'selected' : (!Session::has('currency') && $currency->is_default == 1 ? 'selected' : '') }} >{{$currency->sign. ' '.$currency->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
								@endif
							</div>
                            <div class="right-content">
                                <ul class="social-link">
                                    @php
                                        $social_link = App\Models\Socialsetting::find(1);
                                    @endphp

                                    @if ($social_link->f_status == 1)
                                    <li>
                                        <a href="{{$social_link->facebook}}" class="facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    @endif

                                    @if ($social_link->t_status == 1)
                                    <li>
                                        <a href="{{$social_link->twitter}}" class="twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    @endif

                                    @if ($social_link->l_status == 1)
                                    <li>
                                        <a href="{{$social_link->linkedin}}" class="linkedin">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    @endif

                                    @if ($social_link->g_status == 1)
                                    <li>
                                        <a href="{{$social_link->gplus}}" class="google-plus">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                <div class="user-top-menu-area">
                                    @if(Auth::user())
                                        <div class="user-d-d">
                                            <a href="#" class="u-name">
                                                <i class="fas fa-user"></i>{{ Auth::user()->name }}
                                            </a>
                                            <div class="user-d-d-menu">
                                                <a href="{{ route('user-dashboard') }}"><i class="fas fa-tachometer-alt"></i>{{ __('Dashboard') }}</a>
                                                <a href="{{ route('user-logout') }}"><i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="login-button">
                                            <a href="{{ route('user.login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>
                                        </div>
                                    @endif
                                </div>

                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Top Header Area End -->
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<nav class="navbar navbar-expand-lg navbar-light">
						<a class="navbar-brand" href="{{route('front.index')}}">
                        <img src="{{asset('assets/images/genarel-settings/'.$gs->header_logo)}}" alt="">
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="main_menu"
							aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse fixed-height" id="main_menu">
							<ul class="navbar-nav mr-auto">
								<li class="nav-item">
                                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{route('front.index')}}">{{__('Home')}}</a>
								</li>
								@if($ps->tour_menu ==1)
								<li class="nav-item">
									<a class="nav-link
									 {{ Request::is('tours') ? 'active' : '' }}
									 {{ Request::is('tour/*') ? 'active' : '' }}
									 " href="{{route('front.tours')}}">{{__('Tours')}}</a>
								</li>
								@endif
								@if($ps->hotel_menu == 1)
								<li class="nav-item">
									<a class="nav-link
									 {{ Request::is('hotels') ? 'active' : '' }}
									 {{ Request::is('hotel/*') ? 'active' : '' }}
									 " href="{{route('front.hotels')}}">{{__('Hotels')}}</a>
								</li>
								@endif
								@if($ps->space_menu == 1)
								<li class="nav-item">
									<a class="nav-link
									 {{ Request::is('spaces') ? 'active' : '' }}
									 {{ Request::is('space/*') ? 'active' : '' }}
									 " href="{{route('front.spaces')}}">{{__('Space')}}</a>
								</li>
								@endif
								@if($ps->car_menu == 1)
								<li class="nav-item">
									<a class="nav-link
									 {{ Request::is('cars') ? 'active' : '' }}
									 {{ Request::is('cars/*') ? 'active' : '' }}
									 " href="{{route('front.cars')}}">{{__('Cars')}}</a>
								</li>
								@endif
								@if($ps->blog_menu == 1)
								<li class="nav-item">
									<a class="nav-link
									{{ Request::is('blog') ? 'active' : '' }}
									 {{ Request::is('blog/*') ? 'active' : '' }}
									" href="{{route('front.blog')}}">{{__('Blogs')}}</a>
								</li>
								@endif
								@if($ps->pages_menu == 1)
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle
									{{ Request::is('faq') ? 'active' : '' }}
                                	{{ Request::is('about') ? 'active' : '' }}
									{{ Request::is('privacy') ? 'active' : '' }}"
									 href="#"  role="button" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										{{__('Pages')}}
									</a>
									<ul class="dropdown-menu">
                                        <li><a class="dropdown-item {{ Request::is('faq') ? 'active' : '' }}" href="{{route('front.faq')}}"> <i class="fa fa-angle-double-right"></i>{{__('FAQ')}}</a></li>
                                        @foreach (App\Models\Page::all() as $page)
                                        <li><a class="dropdown-item {{ Request::is($page->slug) ? 'active' : '' }}" href="{{route('front.pages',$page->slug)}}"> <i class="fa fa-angle-double-right"></i>{{$page->title}}</a></li>
                                        @endforeach
									</ul>
								</li>
								@endif
								@if($ps->contact_menu == 1)
								<li class="nav-item">
									<a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{route('front.contact')}}">{{__('Contact')}}</a>
								</li>
								@endif
							</ul>
							<div class="search-pc">
								<div class="serch-icon-area">
									<p class="web-serch">
										<i class="fas fa-search"></i>
									</p>
								</div>
								<div class="search-form-area-mobile">
									<span class="off-serch"><i class="fas fa-times"></i></span>
									<form class="search-form2 d-flex" action="{{route('front.search')}}" method="POST">
										@csrf
										<select name="type" class="mx-3">
											@if($ps->hotel_menu == 1)
											<option value="hotel">{{__('Hotel')}}</option>
											@endif
											@if($ps->tour_menu == 1)
											<option value="tour">{{__('Tour')}}</option>
											@endif
											@if($ps->car_menu == 1)
											<option value="car">{{__('Car')}}</option>
											@endif
											@if($ps->space_menu == 1)
											<option value="space">{{__('Space')}}</option>
											@endif
										</select>
										<input type="text" name="search" placeholder="{{__('Search what you want...')}}">
									</form>
								</div>
							</div>
						</div>
						<div class="search-phone">
							<div class="serch-icon-area">
								<p class="web-serch">
									<i class="fas fa-search"></i>
								</p>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="search-phone d-block d-lg-none">
		<div class="search-form-area-mobile">
			<span class="off-serch"><i class="fas fa-times"></i></span>
			<form class="search-form2" action="{{route('front.search')}}"  method="POST">
			    @csrf
			    	<select name="type" class="mx-3">
					@if($ps->hotel_menu == 1)
					<option value="hotel">{{__('Hotel')}}</option>
					@endif
					@if($ps->tour_menu == 1)
					<option value="tour">{{__('Tour')}}</option>
					@endif
					@if($ps->car_menu == 1)
					<option value="car">{{__('Car')}}</option>
					@endif
					@if($ps->space_menu == 1)
					<option value="space">{{__('Space')}}</option>
					@endif
				</select>
			<input type="text" name="search" placeholder="{{__('Search what you want...')}}">
			</form>
		</div>
	</div>
	<!--Main-Menu Area end-->

    @yield('content')
	<!-- Footer Area Start -->
	<footer class="footer" id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-4">
					<div class="footer-widget about-widget">
						<div class="footer-logo">
							<a href="{{route('front.index')}}">
								<img src="{{asset('assets/images/genarel-settings/'.$gs->footer_logo)}}" alt="footer_logo">
							</a>
						</div>
						<div class="text">
							<p>
								{{ $gs->footer_text }}
							</p>
						</div>

					</div>
				</div>
				<div class="col-md-6 col-lg-4">
					<div class="footer-widget address-widget">
						<h4 class="title">
							Address
						</h4>
						<ul class="about-info">
							<li>
								<p>
									<i class="fas fa-globe"></i>
									{{$ps->street_address}}
								</p>
							</li>
							<li>
								<p>
                                    <i class="fas fa-phone"></i>
                                    {{$ps->contact_number}}
								</p>
							</li>
							<li>
								<p>
                                    <i class="far fa-envelope"></i>
                                    {{$ps->contact_email}}
								</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-lg-4">
						<div class="footer-widget  footer-newsletter-widget">
							<h4 class="title">
								{{__('Newsletter')}}
							</h4>
                            <div class="newsletter-form-area">
                                <form action="{{ route('newsletter.post') }}" id="subscribeform" method="POST">
                                    @csrf
                                    <input type="email" placeholder="{{ __('Your email address...') }}" name="email" id="subemail">
                                    <button type="submit">
                                        <i class="far fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
							<div class="social-links">
								<h4 class="title">
										{{__("We're social, connect with us")}}:
								</h4>
								<div class="fotter-social-links">
									<ul>
										@php
                                        $social_link = App\Models\Socialsetting::find(1);
                                    @endphp
                                    @if ($social_link->f_status == 1)
                                    <li>
                                        <a href="{{$social_link->facebook}}" class="facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($social_link->t_status == 1)
                                    <li>
                                        <a href="{{$social_link->twitter}}" class="twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($social_link->l_status == 1)
                                    <li>
                                        <a href="{{$social_link->linkedin}}" class="linkedin">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($social_link->g_status == 1)
                                    <li>
                                        <a href="{{$social_link->gplus}}" class="google-plus">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($social_link->d_status == 1)
                                    <li>
                                        <a href="{{$social_link->dribble}}" class="google-plus">
                                            <i class="fab fa-dribbble"></i>
                                        </a>
                                    </li>
                                    @endif
									</ul>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="copy-bg">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
							<div class="content">
								<div class="content">
									<p>
                                        {!! $gs->copy_right_text !!}
									</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer Area End -->


	<div class="bottomtotop">
		<i class="fas fa-chevron-right"></i>
	</div>

<input type="hidden" id="user_id" value="{{Auth::user()}}">
	<script>
		'use strict';
		var mainurl = "{{url('/')}}";
		var gs  = @json($gs);
		var lang  = {
          'check'  : '{{ __('ADD NEW') }}',
          'sss'	   : '{{ __('Success !') }}',
		  'login'  : '{{__('Login')}}',
		  'maxsize': 'Maximun tour group size',
        };

	</script>

	<!-- jquery -->
	<script src="{{asset('assets/front/js/jquery-3.6.0.min.js')}}"></script>
	<script src="{{asset('assets/front/js/jquery-migrate-3.3.2.js')}}"></script>
	
	<script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>

	<!-- bootstrap -->
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
	<!-- popper -->
	<script src="{{asset('assets/front/js/popper.min.js')}}"></script>
	<!-- plugin js-->
	<script src="{{asset('assets/front/js/plugin.js')}}"></script>
	<!-- main -->
    <script src="{{asset('assets/front/js/myscript.js')}}"></script>
	<script src="{{asset('assets/front/js/notify.js')}}"></script>
	<script src="{{asset('assets/front/js/main.js')}}"></script>

	@yield('script')

	@if(Session::has('success'))
		<script>
		'use strict'
			$.notify('{{Session::get('success')}}', "success");
		</script>
	@endif
	@if(Session::has('warning'))
		<script>
		'use strict'
			$.notify('{{Session::get('warning')}}', "warning");
		</script>
	@endif
	@if(Session::has('error'))
		<script>
			'use strict'
			$.notify('{{Session::get('error')}}', "error");
		</script>
	@endif

</body>

</html>
