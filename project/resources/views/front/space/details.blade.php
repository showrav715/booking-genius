@extends('layouts.front')
@section('title')
	{{__('Space Details')}} | {{$gs->website_title}}
@endsection

@if($space->meta_tag != null || $space->meta_description != null)
@section('meta_content')
<meta property="og:title" content="{{$space->title}}" />
<meta property="og:description" content="{{ $space->meta_description != null ? $space->meta_description : strip_tags($space->meta_description) }}" />
<meta property="og:image" content="{{asset('assets/images/space/feature-image/'.$space->image->image)}}" />
<meta name="keywords" content="{{ $space->meta_tag }}">
<meta name="description" content="{{ $space->meta_description }}">

@endsection
@endif


@section('content')
    <!-- Tour Details Banner Start -->
	<section class="tour-details-banner" style="background: url({{asset('assets/images/space/banner-image/'.$space->banner_image)}})">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="content">
						<div class="left">
							<h4 class="title">
								{{$space->title}}
							</h4>
						</div>
						@if($space->video)
						<div class="right-video">
							<a href="{{$space->video.'/aabadc'}}" class="video-play-btn mfp-iframe">
								<img src="{{asset('assets/front/images/video-play-icon.png')}}" alt="">
							</a>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Tour Details Banner End -->

	<!-- Tour Top info Area Start -->
	<section class="tour-top-info">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="info-content">
						<div class="review-box">
							<div class="rating">
								{{$space->review()}} <small>/5</small>
							</div>
							<div class="review">
								{{$space->review_count() }} {{__('Review')}}
							</div>
						</div>
						<div class="row">
							<div class="col-xl-2 col-lg-6 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/clock.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Bed')}}
										</h5>
										<p>
											{{$space->extra_bed}}
										</p>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/relax.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Bathroom')}}
										</h5>
										<p>
											{{$space->extra_bathroom}}
										</p>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/group.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Square')}}
										</h5>
										<p>
											{{$space->extra_square}} sqft
										</p>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/location.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Location')}}
										</h5>
										<p>
											{{$space->country->country}},{{$space->state->state}}
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Tour Top info Area Start -->


	<!-- Single Details Area Start -->
	<section class="single-details">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">


					@if($space->gallery->count() > 0)
						<div class="model-gallery-image">
							<div class="one-item-slider">
								@foreach ($space->gallery->where('type','space')->where('imagable_id',$space->id) as $gal_image)
								<div class="item"><img src="{{asset('assets/images/space/gallery/'.$gal_image->image)}}" alt="gallery-image"></div>

								@endforeach
							</div>
							<ul class="all-item-slider">
								@foreach ($space->gallery->where('type','space')->where('imagable_id',$space->id) as $gal_image)
								<li><img src="{{asset('assets/images/space/gallery/'.$gal_image->image)}}" alt="gallery-image"></li>
								@endforeach

							</ul>
						</div>
					@endif
					<div class="overview-area">
						<h4 class="title">
							{{__('Overview')}} :
						</h4>
                        <p>
							 <p>{!! $space->description !!}}</p>
						</p>

					</div>
                    <div class="map-location-area mt">
						<h4 class="main-title">
							{{__('Space Facilities')}}
						</h4>
                        @php
                            $import = explode(',',implode(',',array_unique(explode(',',$space->space_attr_id))));
                            $combain = array_combine(explode(',',$space->attr_term_id),explode(',',$space->space_attr_id));
                            $term = explode(',',$space->attr_term_id);

                            $data = array();

                            foreach ($import as $attr => $attrvalue) {
                                $row = array();
                                $i = 0;
                                foreach ($combain as $termkey => $termval) {
                                    if($attrvalue == $termval){
                                        $row[$i] = $termkey;
                                        $i++;
                                    }
                                }
                                $data[$attrvalue] = $row;
                            }
                        @endphp
                        @foreach ($data as $key => $term_id)
                        @php
                            $attr = App\Models\SpaceAttr::findOrFail($key);
                        @endphp
                        <div class="row t-extra-f">
                            <div class="col-lg-12">
                                <h4 class="title">
                                    {{$attr->name}} :
                                </h4>
                            </div>
                            <div class="col-md-12">
                                @foreach ($term_id as $term)
                                @php
                                    $termName = App\Models\SpaceTerm::find($term)->name;
                                @endphp

                                    <p class="l"><i class="far fa-check-circle"></i>{{$termName}}</p>

                                @endforeach
                            </div>
                        </div>
                    @endforeach

					</div>
					<div class="map-location-area">
						<h4 class="title">
							{{__('Space Location')}} : {{$space->country->country}},{{$space->state->state}},{{$space->address}}
						</h4>
						<iframe
                            height="350"
                            frameborder="0" style="border:0; width: 100%;"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB1GpE4qeoJ__70UZxvX9CTMUTZRZNHcu8&q={{ $space->country->country }},{{$space->state->state}},{{$space->address}}" allowfullscreen>
                          </iframe>
					</div>

					@if($space->faq_title)
					<div class="tour-faq-area">
						<h4 class="title">
							{{__('FAQs')}}
						</h4>
                        <div class="accordion" id="tour-faq">
                            @foreach (explode(',,,',$space->faq_title) as $id => $faq)
                            @php
                                $content = explode(',,,',$space->faq_content);
                            @endphp
                            <div class="single-accordion">
                                <div class="accordion-header">
                                    <h4 class="title" data-toggle="collapse" data-target="#collapse{{$id}}" aria-expanded="true" aria-controls="collapseOne">
                                    <img src="{{asset('assets/front/images/question.png')}}" alt="">{{$faq}}
                                    </h4>
                                </div>

                                <div id="collapse{{$id}}" class="collapse " data-parent="#tour-faq">
                                <div class="accordion-body">
                                    {{ $content[$id] }}
                                </div>
                                </div>
                            </div>
                            @endforeach
                      </div>
					</div>
					@endif
					

					<div class="review-area">
						<h4 class="title">
						{{__('Review')}}
						</h4>
						{{__('Average Review : ')}} <span class="average_review">{{$space->review()}}</span>
						<ul class="review-list">
							@if($reviews->count()>0)
							@foreach($reviews as $key => $review)
								<li>
									<div class="single-comment">
										<div class="left-area">
											<img src="{{$review->user->photo ? asset('assets/images/users/'.$review->user->photo) : asset('assets/images/noimage.png')}}" alt="">
											<h5 class="name">{{$review->user->name}}</h5>
											<p class="date">{{$review->created_at->format('M-d-Y')}}</p>
										</div>
										<div class="right-area">
											<div class="header-area">
												<div class="stars-area">
													<div class="stars">
														<div class="ratings">
															<div class="empty-stars"></div>
															<div class="full-stars" style="width:{{$review->review * 20}}%"></div>
														  </div>
													</div>
												</div>
											</div>
											<div class="comment-body">
												<p>
													{!! $review->comment !!}
												</p>
											</div>
											<div class="comment-footer">
												<div class="links">
													<a href="#" class="report">{{__('Report Abouse')}}</a>
												</div>
											</div>
										</div>
									</div>
								</li>
								@endforeach
								@else
									<li>
										{{__('No Reviews')}}
									</li>
								@endif
						</ul>
						@if(Auth::user() && App\Models\Order::where('user_id',Auth::user()->id)->where('item_id',$space->id)->where('order_type','Space')->exists())
						@if(App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$space->id)->exists())
						<input type="hidden" id="now_review" value="{{App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$space->id)->first()->review}}">
						@else
						<input type="hidden" id="now_review" value="0">
						@endif

						<div class="review-area">
							<h4 class="title">{{__('Add Review & Rate')}}</h4>
							<p class="text">{{__('Your email address will not be published. Required fields are marked')}} *</p>
							<div class="star-area">
								<ul class="star-list">
									<li class="review-value review-1">
										<i class="fas fa-star" data="1"></i>
									</li>
									<li class="review-value review-2">
										<i class="fas fa-star" data="2"></i>
										<i class="fas fa-star" data="2"></i>
									</li>
									<li class="review-value review-3">
										<i class="fas fa-star" data="3"></i>
										<i class="fas fa-star" data="3"></i>
										<i class="fas fa-star" data="3"></i>
									</li>
									<li class="review-value review-4">
										<i class="fas fa-star" data="4"></i>
										<i class="fas fa-star" data="4"></i>
										<i class="fas fa-star" data="4"></i>
										<i class="fas fa-star" data="4"></i>
									</li>
									<li class="review-value review-5">
										<i class="fas fa-star" data="5"></i>
										<i class="fas fa-star" data="5"></i>
										<i class="fas fa-star" data="5"></i>
										<i class="fas fa-star" data="5"></i>
										<i class="fas fa-star" data="5"></i>
									</li>
								</ul>
							</div>

						</div>
						<div class="write-comment-area">
							<form action="{{route('front.review.store')}}" method="POST" id="reviewForm">
								@csrf
								<input type="hidden" name="review" id="reviewValue" value="">
								<input type="hidden" name="type" value="space">
								<input type="hidden" name="review_id" value="{{$space->id}}">
								<div class="row">
									<div class="col-lg-12">
										<textarea name="comment" placeholder="{{__('Your Review')}} *"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<button class="mybtn1" type="submit">{{__('Post Comment')}}</button>
									</div>
								</div>
							</form>
						</div>
						@else
						@if(!Auth::user())
							<a class="mybtn1" href="{{route('user.login')}}">{{__('Login')}}</a>
						@endif
						@endif
					</div>
				</div>
				<div class="col-lg-4">
					<div class="aside-right">
						<div class="price-area">
							@if($space->discount)
							<div class="discount">
								{{$space->discount}}%
							</div>
							@endif
							<p class="price">
								{{PriceHelper::showCurrencyPrice($space->main_price)}}
								@if($space->sale_price)
								<small><del>{{PriceHelper::showCurrencyPrice($space->sale_price)}}</del></small>
								@endif
							</p>
						</div>

							<div class="book-now-area">
								<h4 class="title">
									{{__('Book A Reservation')}}
								</h4>
								<div class="start-time">
									<span>
										{{__('Start Date')}} :
									</span>
									<input type="text" class="date-range date_range" placeholder="Check" name="daterange" value="" />
								</div>


                                @if($space->is_extra_price == 1)
								<div class="extra-price-wizerd">
									<h5 class="title">
										{{__('Extra prices')}}:
									</h5>
									<ul class="extra-list">
                                        @foreach (explode(',,,',$space->extra_price_name) as $key => $extra_price_name)
                                        @php
                                            $price = explode(',,,',$space->extra_price);
                                            $type = explode(',,,',$space->extra_price_type);
                                        @endphp
                                        <li>
											<div class="left">
                                            <input type="checkbox" id="{{$price[$key]}}" data-href="{{PriceHelper::showPrice($price[$key])}}" class="space_extra_prices" value="{{$key}}"> <label for="{{$price[$key]}}">{{$extra_price_name}}</label>
                                            <small class="mr-2">({{__('per ')}}{{$type[$key]}})</small>
											</div>
											<div class="right">
												<span>{{PriceHelper::showCurrency()}}</span> <span class="extra_price">{{PriceHelper::showPrice($price[$key])}}</span>
											</div>
										</li>
                                        @endforeach
									</ul>
                                </div>
								@endif <hr>
								<div class="date_show d-none">
									<li>
										<span>{{__('Start date')}}:</span>
										<span class="start_date_show"></span>
									</li>
									<li>
										<span>{{__('End date')}}:</span>
										<span class="end_date_show"></span>
									</li>
								</div>
								<div class="extra-price-wrap d-flex justify-content-between is_mobile mt-3">
									<div  class="flex-grow-1"><label>
											<h4>{{__('Total')}}:</h4>
										</label></div>
									<div class="total-room-price"><span>{{PriceHelper::showCurrency()}}</span> <span class="total_price"> 0.00 </span></div>
								</div>
								<button type="button"  class="book-btn book_button">{{__('Book Now')}}</button>
							</div>

						<div class="organize-by">
							<h4 class="title">
									{{__('Organized by')}}
							</h4>
							<div class="organizer-profile">
								@php
								if($space->author_type == 'Admin'){
									$organizer =   App\Models\Admin::findOrFail(1);
								}else{
									$organizer =	App\Models\User::findOrFail($space->author_id);
								}

								@endphp
								<div class="left">
									@if($space->author_type =='Admin')
									<img src="{{$organizer->photo ? asset('assets/images/admins/'.$organizer->photo) : asset('assets/images/noimage.png')}}" alt="image">
									@else
									<img src="{{$organizer->photo ? asset('assets/images/users/'.$organizer->photo) : asset('assets/images/noimage.png')}}" alt="image">
									@endif
								</div>
								<div class="right">
									<a href="javascript:;">
										<h5 class="title">
											{{$organizer->name}}
										</h5>
									</a>
									<p class="date">
										{{__('Member Since')}} {{$organizer->created_at->format('Y')}}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Single Details Area End -->

	<input type="hidden" value="{{route('space.availability.check')}}" id="applyBtnUrl">
	<input type="hidden" value="{{$space->id}}" id="space_id_ajax">
	<input type="hidden" value="{{PriceHelper::showPrice($space->main_price)}}" id="spaceUpPriceAjax">
	@include('front.inc.related')

@endsection


@section('script')
<script src="{{asset('assets/front/js/space/details.js')}}"></script>
<script>
	    $(".one-item-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".all-item-slider",
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            vertical: false,
            horizontal: true,
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    $(".all-item-slider").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: ".one-item-slider",
      arrows: true,
      prevArrow: '<i class="fa fa fa-chevron-left slidPrv4"></i>',
      nextArrow: '<i class="fa fa-chevron-right slidNext4"></i>',
      dots: false,
      centerMode: false,
      centerPadding: "20px",
      focusOnSelect: true,
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            vertical: false,
            horizontal: true,
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        
      ],
    });
</script>
@endsection
