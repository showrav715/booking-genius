@extends('layouts.front')
@section('title')
	{{__('Home | ')}} {{$gs->website_title}}
@endsection

@section('content')

@if($featured->count() > 0 && $ps->feature_section != 0)

<div class="banner-active">
    @foreach ($featured as $feature)
    <div class="single-banner bg_cover" style="background-image: url({{asset('assets/images/feature/'.$feature->photo)}});">
        <div class="banner-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="banner-content">
                            <h1 data-animation="fadeInLeft" data-delay="0.9s" class="title">{{$feature->title}}</h1>
                            <p data-animation="fadeInLeft" data-delay="1.3s">{{$feature->details}}</p>
                            <a data-animation="fadeInUp" data-delay="1.6s" class="mybtn1" href="{{ $feature->button_link }}">{{ $feature->button_name }} <i class="fal fa-long-arrow-right"></i></a>
                        </div> <!-- banner content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
    </div>
    @endforeach
</div>

@endif
	<!-- Frature Area End -->
	@if($locations->count() > 0 && $ps->destinations_section == 1)
	<!-- Top Dastination Area start -->
	<section class="top-dastination">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header-area">
						<h4 class="title">
							{{$ps->destination_title}}
						</h4>
					</div>
				</div>
			</div>
			<div class="row">
				@foreach ($locations as $country)
				<div class="col-lg-4 col-md-6">
					<div  class="single-destination">
						<img src="{{asset('assets/images/location/country/'.$country->image->image)}}" alt="country-image">
						<div class="overlay"></div>
						<div class="content">
							<h4 class="title">
								{{$country->country}}
							</h4>
							@if(count($country->hotel) > 0)
								<form  class="tour-count" action="{{route('front.hotels')}}" method="get">
									<input type="hidden" name="country_id" value="{{$country->id}}">
									<button type="submit">({{count($country->hotel)}}) {{__('Hotel')}}</button>
								</form>
							@endif
							@if(count($country->tour) > 0)
								<form  class="tour-count" action="{{route('front.tours')}}" method="get">
									<input type="hidden" name="country_id" value="{{$country->id}}">
									<button type="submit">({{count($country->tour)}}) {{__('TOUR')}}</button>
								</form>
							@endif
							@if(count($country->car) > 0)
								<form  class="tour-count" action="{{route('front.cars')}}" method="get">
									<input type="hidden" name="country_id" value="{{$country->id}}">
									<button type="submit">({{count($country->car)}}) {{__('Cars')}}</button>
								</form>
							@endif


							@if(count($country->space) > 0)
								<form  class="tour-count" action="{{route('front.spaces')}}" method="get">
									<input type="hidden" name="country_id" value="{{$country->id}}">
									<button type="submit">({{count($country->space)}}) {{__('Spaces')}}</button>
								</form>
							@endif
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
@endif
	@if($tours->count() > 0 && $ps->tour_section == 1 && $ps->tour_menu == 1)
	<section class="tranding-tour">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header-area">
						<h4 class="title">
							{{$ps->tour_title}}
						</h4>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="tour-slider">
						@foreach ($tours as $tour)
						<div class="slide-item">
							<div  class="single-tours">
								<div class="img-area">
									@if($tour->discount)
									<div class="discount">
										{{$tour->discount}}%
									</div>
									@endif
									@if($tour->is_feature)
									<div class="feature">
											{{__('Featured')}}
									</div>
									@endif
									<img src="{{asset('assets/images/tour/feature-image/'.$tour->image->image)}}" alt="tour-feature">
								</div>
								<div class="content">
									<span class="add-favotite corsor-pointer" data-href="{{route('front.favarite',$tour->id.',,tour')}}">
										@if(App\Models\Favarite::where('data_id',$tour->id)->where('type','tour')->exists())
											<i class="fas fa-check"></i>
										@else
										<i class="far fa-heart"></i>
										@endif
									</span>
									<p class="country">
											<i class="fas fa-plane"></i>{{$tour->country->country}}
									</p>
									<h4 class="title">
										<a href="{{route('tour.details',$tour->slug)}}">{{$tour->title}}</a>
									</h4>
									<div class="review-area">
										<div class="stars">
											<div class="ratings">
												<div class="empty-stars"></div>
												<div class="full-stars" style="width:{{$tour->review() * 20}}%"></div>
											  </div>
										</div>
										<span class="review">
											{{$tour->review()}} {{__('Review')}}
										</span>
									</div>
									<div class="price-area-wrapper">
										<div class="left-area">
											<div class="icon">
													<i class="fas fa-wallet"></i>
											</div>
											<div class="price">
												{{PriceHelper::showCurrencyPrice($tour->main_price)}}
												@if($tour->sale_price)
												<small><del>{{PriceHelper::showCurrencyPrice($tour->sale_price)}}</del></small>
												@endif
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
	@if($hotels->count() > 0 && $ps->hotel_section == 1 && $ps->hotel_menu == 1)
	<section class="tranding-tour">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header-area">
						<h4 class="title">
							{{$ps->hotel_title}}
						</h4>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="tour-slider">
						@foreach ($hotels as $hotel)
						<div class="slide-item">
							<div  class="single-tours">
								<div class="img-area">
										@if($hotel->discount)
										<div class="discount">
											{{$hotel->discount}}%
										</div>
										@endif
										@if($hotel->is_feature)
										<div class="feature">
												{{__('Featured')}}
										</div>
										@endif
									<img src="{{asset('assets/images/hotel-image/'.$hotel->image->image)}}" alt="hotel-feature">
								</div>
								<div class="content">
									<span class="add-favotite corsor-pointer" data-href="{{route('front.favarite',$hotel->id.',,hotel')}}">
										@if(App\Models\Favarite::where('data_id',$hotel->id)->where('type','hotel')->exists())
											<i class="fas fa-check"></i>
										@else
										<i class="far fa-heart"></i>
										@endif
									</span>
									<p class="country">
											<i class="fas fa-plane"></i>{{$hotel->country->country}}
									</p>
									<h4 class="title">
										<a href="{{route('hotel.details',$hotel->slug)}}">{{$hotel->title}}</a>
									</h4>
									<div class="review-area">
										<div class="stars">
											<div class="ratings">
												<div class="empty-stars"></div>
												<div class="full-stars" style="width:{{$hotel->review() * 20}}%"></div>
											  </div>
										</div>
										<span class="review">
											{{$hotel->review()}} {{__('Review')}}
										</span>
									</div>
									<div class="price-area-wrapper">
										<div class="left-area">
											<div class="icon">
													<i class="fas fa-wallet"></i>
											</div>
											<div class="price">
												{{PriceHelper::showCurrencyPrice($hotel->main_price)}}
												@if($hotel->sale_price)
												<small><del>{{PriceHelper::showCurrencyPrice($hotel->sale_price)}}</del></small>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
@endif

@if($cars->count() > 0 && $ps->car_section == 1 && $ps->car_menu == 1)
	<section class="tranding-tour">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header-area">
						<h4 class="title">
							{{$ps->car_title}}
						</h4>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="tour-slider">
						@foreach ($cars as $car)
						<div class="slide-item">
							<div  class="single-tours">
								<div class="img-area">
									@if($car->discount)
									<div class="discount">
										{{$car->discount}}%
									</div>
									@endif
										@if($car->is_feature)
										<div class="feature">
												{{__('Featured')}}
										</div>
										@endif
									<img src="{{asset('assets/images/car/feature-image/'.$car->image->image)}}" alt="hotel-feature">
								</div>
								<div class="content">
									<span class="add-favotite corsor-pointer" data-href="{{route('front.favarite',$car->id.',,car')}}">
										@if(App\Models\Favarite::where('data_id',$car->id)->where('type','car')->exists())
											<i class="fas fa-check"></i>
										@else
										<i class="far fa-heart"></i>
										@endif
									</span>
									<p class="country">
											<i class="fas fa-plane"></i>{{$car->country->country}}
									</p>
									<h4 class="title">
										<a href="{{route('car.details',$car->slug)}}">{{$car->title}}</a>
									</h4>
									<div class="review-area">
										<div class="stars">
											<div class="ratings">
												<div class="empty-stars"></div>
												<div class="full-stars" style="width:{{$car->review() * 20}}%"></div>
											  </div>
										</div>
										<span class="review">
											{{$car->review()}} {{__('Review')}}
										</span>
									</div>
									<div class="price-area-wrapper">
										<div class="left-area">
											<div class="icon">
													<i class="fas fa-wallet"></i>
											</div>
											<div class="price">
												{{PriceHelper::showCurrencyPrice($car->main_price)}}
												@if($car->sale_price)
												<small><del>{{PriceHelper::showCurrencyPrice($car->sale_price)}}</del></small>
												@endif
											</div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</section>

@endif

@if($spaces->count() > 0 && $ps->space_section == 1 && $ps->space_menu == 1)

	<section class="tranding-tour">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="header-area">
						<h4 class="title">
							{{$ps->space_title}}
						</h4>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="tour-slider">
						@foreach ($spaces as $space)
						<div class="slide-item">
							<div  class="single-tours">
								<div class="img-area">
									@if($space->discount)
									<div class="discount">
										{{$space->discount}}%
									</div>
									@endif
									
										@if($space->is_feature)
										<div class="feature">
												{{__('Featured')}}
										</div>
										@endif
								
									<img src="{{asset('assets/images/space/feature-image/'.$space->image->image)}}" alt="hotel-feature">
								</div>
								<div class="content">
									<span class="add-favotite corsor-pointer" data-href="{{route('front.favarite',$space->id.',,space')}}">
										@if(App\Models\Favarite::where('data_id',$space->id)->where('type','space')->exists())
											<i class="fas fa-check"></i>
										@else
										<i class="far fa-heart"></i>
										@endif
									</span>
									<p class="country">
											<i class="fas fa-plane"></i>{{$space->country->country}}
									</p>
									<h4 class="title">
										<a href="{{route('space.details',$space->slug)}}">{{$space->title}}</a>
									</h4>
									<div class="review-area">
										<div class="stars">
											<div class="ratings">
												<div class="empty-stars"></div>
												<div class="full-stars" style="width:{{$space->review() * 20}}%"></div>
											  </div>
										</div>
										<span class="review">
											{{$space->review()}} {{__('Review')}}
										</span>
									</div>
									<div class="price-area-wrapper">
										<div class="left-area">
											<div class="icon">
													<i class="fas fa-wallet"></i>
											</div>
											<div class="price">
												{{PriceHelper::showCurrencyPrice($space->main_price)}}
												@if($space->sale_price )
												<small><del>{{PriceHelper::showCurrencyPrice($space->sale_price)}}</del></small>
												@endif
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</section>

@endif
@if($members->count() > 0  && $ps->member_section == 1 )
	<section class="testimonial" style="background: url({{asset('assets/images/page-setting/'.$ps->member_background)}})">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="section-heading text-center">
						<h2 class="title">
							{{$ps->member_title}}
						</h2>
						<p class="text">
							{{$ps->member_text}}
						</p>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-12">
					<div class="testimonial-slider">
						@foreach ($members as $member)
						<div class="single-testimonial">
							<div class="review-text">
								<p>
									{{$member->message}}
								</p>
								<img src="{{asset('assets/front/images/quot.png')}}" alt="">
							</div>
							<div class="people">
								<div class="img">
										<img src="{{asset('assets/images/member/'.$member->photo)}}" alt="">
								</div>
								<div class="content">
								<h4 class="title">{{$member->name}}</h4>
								<p class="designation">{{substr(strip_tags($member->designation),0, 200)}}</p>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Testimonial Area End -->
	@endif

	@if($blogs->count() > 0 && $ps->blog_section == 1 && $ps->blog_menu == 1)
	<!-- Blog Area Start -->
	<section class="blog">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="section-heading text-center">
						<h2 class="title">
							{{$ps->blog_title}}
						</h2>
						<p class="text">
							{{$ps->blog_text}}
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				@foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6">
					<a href="{{route('front.blog.show',$blog->slug)}}" class="single-blog">
						<div class="img">
							<img src="{{asset('assets/images/blogs/'.$blog->image->image)}}" alt="">
						</div>
						<div class="content">
							<span>
								<h4 class="title">
									{{$blog->title}}
								</h4>
							</span>
							<div class="text">
								<p>
									{{substr(strip_tags($blog->description),0, 100)}}...
								</p>
							</div>

							<ul class="top-meta">
									<li>
										<span>
												<i class="far fa-clock"></i>{{Carbon\Carbon::parse($blog->created_at)->diffForHumans()}}
										</span>
									</li>
								</ul>
						</div>
					</a>
				</div>
                @endforeach
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<a href="{{route('front.blog')}}" class="view-all-btn">{{__('View All')}}</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Blog Area End -->
	@endif
@endsection

