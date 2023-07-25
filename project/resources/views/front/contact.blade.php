@extends('layouts.front')

@section('title')
	{{__('Contact Us | ')}} {{$gs->website_title}}
@endsection

@section('content')
    <!--Main Breadcrumb Area Start -->
	<div class="main-breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="pagetitle">
							{{__('Contact Us')}}
						</h1>
						<ul class="pages">
							<li>
							<a href="{{route('front.index')}}">
									{{__('Home')}}
								</a>
							</li>
							<li class="active">
							<a href="{{route('front.contact')}}">
									{{__('Contact Us')}}
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--Main Breadcrumb Area End -->


	<!-- Contact Us Area Start -->
	<section class="contact-us">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-10">
					<div class="header-area">
						<h4 class="title">
								@if($ps->contact_title)
								{{$ps->contact_title}}
								@endif
						</h4>
						@if($ps->contact_subtitle)
						<p class="text">{{$ps->contact_subtitle}}</p>
						@endif
					
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-lg-7">
					<div class="left-area">
						<div class="contact-form">
							<form action="{{route('front.contact.submit')}}" id="contactform" method="POST">
                                @csrf @include('includes.admin.form-both')
								<ul>
									<li>
										<input type="text" class="input-field" required placeholder="{{__('Enter Name')}}" name="name">
									</li>
									<li>
										<input type="email" class="input-field" required placeholder="{{__('Email Address')}}" name="email">
									</li>
									<li>
										<input type="text" class="input-field" required placeholder="{{__('Email Phone')}}" name="phone">
									</li>
									
									<li>
										<textarea class="input-field textarea" name="message" required placeholder="{{__('Your Message')}}"></textarea>
									</li>
								</ul>
								<ul class="captcha-area">
									<li>
										<p><img class="codeimg" src="{{asset('assets/images/capcha_code.png')}}" alt="code"><i data-href="{{url('contact/refresh_code')}}" class="fas fa-sync-alt pointer refresh_code "></i></p>
									</li>
									<li>
										<input type="text" class="input-field" name="codes" placeholder="{{__('Enter Code')}}">
									</li>
								</ul>
                                <button class="submit-btn mybtn1" type="submit">{{__('Send Message')}} 
                                    <span class="spinner-grow spinner-grow-sm d-none" style="padding:10px" role="status"></span>
                                </button>
                                <input type="hidden" value="{{ $ps->contact_email }}" name="to">
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="right-area">
						<div class="contact-info">
							<div class="left ">
									<div class="icon">
											<img src="{{asset('assets/front/images/emal.png')}}" alt="">
									</div>
							</div>
							<div class="content">
									<h4 class="title">
										{{__('Email')}}
									</h4>
                                    <a href="javascript:;">
										{{$ps->contact_email}}
									</a>
									
							</div>
						</div>
						<div class="contact-info">
							<div class="left ">
									<div class="icon">
											<img src="{{asset('assets/front/images/location.png')}}" alt="">
									</div>
							</div>
							<div class="content">
									<h4 class="title">
										{{__('Location')}} 
									</h4>
                                    <a href="javascript:;">
										{{$ps->street_address}}
									</a>
									
							</div>
						</div>
						<div class="contact-info">
							<div class="left ">
									<div class="icon">
											<img src="{{asset('assets/front/images/call.png')}}" alt="">
									</div>
							</div>
							<div class="content">
									<h4 class="title">
										{{__('Phone')}}
									</h4>
										<a href="javascript:;">
												{{$ps->contact_number}}
										</a>
										
							</div>
						</div>
						<div class="social-links">
							<h4 class="title">{{__('Find us here')}} :</h4>
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
	</section>
	<!-- Contact Us Area End-->
@endsection


@section('script')

    <script>
    
    $.get($(this).data('href'), function (data, status) {
      $('.codeimg').attr("src", "" + mainurl + "/assets/images/capcha_code.png?time=" + Math.random());
    });

</script>
@endsection