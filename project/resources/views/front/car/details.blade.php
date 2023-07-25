@extends('layouts.front')
@section('title')
	{{__('Car Details')}} | {{$gs->website_title}}
@endsection

@if($car->meta_tag != null || $car->meta_description != null)

@section('meta_content')
<meta property="og:title" content="{{$car->title}}" />
<meta property="og:description" content="{{ $car->meta_description != null ? $car->meta_description : strip_tags($car->meta_description) }}" />
<meta property="og:image" content="{{asset('assets/images/car/feature-image/'.$car->image->image)}}" />
<meta name="keywords" content="{{ $car->meta_tag }}">
<meta name="description" content="{{ $car->meta_description }}">

@endsection
@endif

@section('content')
    <!-- Tour Details Banner Start -->
	<section class="tour-details-banner" style="background: url({{asset('assets/images/car/banner-image/'.$car->banner_image)}})">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="content">
						<div class="left">
							<h4 class="title">
								{{$car->title}}
							</h4>
						</div>
						@if($car->video)
						<div class="right-video">
							<a href="{{$car->video}}" class="video-play-btn mfp-iframe">
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
								{{$car->review()}} <small>/5</small>
							</div>
							<div class="review">
								{{$car->review_count()}} {{__('Review')}}
							</div>
						</div>
						<div class="row">
							<div class="col-xl-2 col-lg-3 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/clock.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Passenger')}}
										</h5>
										<p>
											{{$car->passenger}}
										</p>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-3 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/relax.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Gear Shift')}}
										</h5>
										<p>
											{{$car->gear}}
										</p>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-3 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/group.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Baggage')}}
										</h5>
										<p>
											{{$car->baggage}}
										</p>
									</div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-3 col-sm-6">
								<div class="info-box">
									<div class="left">
										<img src="{{asset('assets/front/images/icon/location.png')}}" alt="">
									</div>
									<div class="right">
										<h5 class="title">
											{{__('Door')}}
										</h5>
										<p>
											{{$car->door}}
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
					<div class="model-gallery-image">
						<div class="one-item-slider">
                            @foreach ($car->gallery->where('imagable_id',$car->id)->where('type','car') as $gallery)
                            <div class="item"><img src="{{asset('assets/images/car/gallery/'.$gallery->image)}}" alt=""></div>
                            @endforeach
						</div>
						<ul class="all-item-slider">
                            @foreach ($car->gallery->where('imagable_id',$car->id)->where('type','car') as $gallery)
                            <li><img src="{{asset('assets/images/car/gallery/'.$gallery->image)}}" alt=""></li>
                            @endforeach
						</ul>
					</div>
					<div class="overview-area">
						<h4 class="title">
							{{__('Overview')}} :
						</h4>
						<p>
                            {{ $car->description }}
						</p>
					</div>


                    <div class="map-location-area mt">
						<h4 class="main-title">
							{{__('Car Feature')}}
						</h4>
                        @php
                            $import = explode(',',implode(',',array_unique(explode(',',$car->car_attr_id))));
                            $combain = array_combine(explode(',',$car->attr_term_id),explode(',',$car->car_attr_id));
                            $term = explode(',',$car->attr_term_id);

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
                        $attr = App\Models\CarAttr::findOrFail($key);
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
                                $termName = App\Models\CarTerm::find($term)->name;
                            @endphp

                                <p class="l"><i class="far fa-check-circle"></i>{{$termName}}</p>

                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    </div>

					<div class="map-location-area">
						<h4 class="title">
							{{__('Car Location')}} :
						</h4>
						<iframe
                            height="350"
                            frameborder="0" style="border:0; width: 100%;"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB1GpE4qeoJ__70UZxvX9CTMUTZRZNHcu8&q={{ $car->country->country }},{{$car->state->state}},{{$car->address}}" allowfullscreen>
                          </iframe>
					</div>
					@if ($car->faq_title)
					<div class="tour-faq-area">
						<h4 class="title">
							{{__('FAQs')}}
						</h4>
						<div class="accordion" id="tour-faq">
								@foreach (explode(',,,',$car->faq_title) as $id => $faq)
								@php
									$content = explode(',,,',$car->faq_content);
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
						{{__('Average Review : ')}} <span class="average_review">{{$car->average_review}}</span>
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
						@if(Auth::user() && App\Models\Order::where('user_id',Auth::user()->id)->where('item_id',$car->id)->where('order_type','Car')->exists())
						@if(App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$car->id)->exists())
						<input type="hidden" id="now_review" value="{{App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$car->id)->first()->review}}">
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
								<input type="hidden" name="type" value="car">
								<input type="hidden" name="review_id" value="{{$car->id}}">
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
							@if($car->discount)
							<div class="discount">
								{{$car->discount}}%
							</div>
							@endif
							<p class="price">
							{{PriceHelper::showCurrencyPrice($car->main_price)}}
							@if($car->sale_price)
							<small><del>{{PriceHelper::showCurrencyPrice($car->sale_price)}}</del></small>
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
									<input type="text" class="date-range date_range" name="daterange" value="" />
								</div>
								<div class="people-count">
									<div class="left">
										<h5 class="title">
											{{__('Number')}}
										</h5>
									</div>
									<div class="right">
										<div class="qty">
											<ul>
												<li>
													<span class="children_qtymins reducing">
														<i class="fas fa-minus"></i>
													</span>
												</li>
												<li>
													<span class="children_qty">1</span>
												</li>
												<li>
													<span class="children_qtyplus adding">
														<i class="fas fa-plus"></i>
													</span>
												</li>
											</ul>
										</div>
									</div>
                                </div>
                                @if($car->is_extra_price == 1)
								<div class="extra-price-wizerd">
									<h5 class="title">
										{{__('Extra prices')}}:
									</h5>
									<ul class="extra-list">
                                        @foreach (explode(',,,',$car->extra_price_name) as $key => $extra_price_name)
                                        @php
                                            $price = explode(',,,',$car->extra_price);
                                            $type = explode(',,,',$car->extra_price_type);
                                        @endphp
                                        <li>
											<div class="left">
                                            <input type="checkbox" id="a{{$key}}" data-href="{{PriceHelper::showPrice($price[$key])}}" class="car_extra_prices" value="{{$key}}"> <label for="a{{$key}}">{{$extra_price_name}}</label>
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
									if($car->author_type == 'Admin'){
										$organizer =   App\Models\Admin::findOrFail(1);;
									}else{
										$organizer =	App\Models\User::findOrFail($car->author_id);
									}


									@endphp
									<div class="left">
										@if($car->author_type =='Admin')
										<img src="{{$organizer->photo ? asset('assets/images/admins/'.$organizer->photo) : asset('assets/images/noimage.png')}}" alt="image">
										@else
										<img src="{{$organizer->photo ? asset('assets/images/users/'.$organizer->photo) : asset('assets/images/noimage.png')}}" alt="image">
										@endif
									</div>
									<div class="right">
										<a href="#">
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
	@include('front.inc.related')
	<input type="hidden" id="carIdAjax" value="{{$car->id}}">
	<input type="hidden" id="ajaxQty" value="{{$qty}}">
	<input type="hidden" id="carMainPriceAjax" value="{{PriceHelper::showPrice($car->main_price)}}">
	<input type="hidden" id="CarDataChcekUrl" value="{{route('car.availability.check')}}">

@endsection

@section('script')
<script src="{{asset('assets/front/js/car/details.js')}}"></script>
@endsection
