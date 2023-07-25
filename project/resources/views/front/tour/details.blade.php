@extends('layouts.front')
@section('title')
	{{__('Tour Details')}} | {{$gs->website_title}}
@endsection

@if($tour->meta_tag != null || $tour->meta_description != null)
@section('meta_content')
<meta property="og:title" content="{{$tour->title}}" />
<meta property="og:description" content="{{ $tour->meta_description != null ? $tour->meta_description : strip_tags($tour->meta_description) }}" />
<meta property="og:image" content="{{asset('assets/images/tour/feature-image/'.$tour->image->image)}}" />
<meta name="keywords" content="{{ $tour->meta_tag }}">
<meta name="description" content="{{ $tour->meta_description }}">
@endsection
@endif

@section('content')
    <!--Main-Menu Area Start-->

	<!-- Tour Details Banner Start -->
<section class="tour-details-banner" style="background:url({{asset('assets/images/tour/banner-image/'.$tour->banner_image)}})">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="content">
						<div class="left">
							<h4 class="title">
								{{$tour->title}}
							</h4>
						</div>
						@if($tour->video)
						<div class="right-video">
							<a href="{{$tour->video}}" class="video-play-btn mf6 p-iframe">
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

    <section class="tour-top-info">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="info-content">
						<div class="review-box">
							<div class="rating">
								{{$tour->review()}} <small>/5</small>
							</div>
							<div class="review">
								{{$tour->review_count() }} {{__('Review')}}
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
											{{__('Duration')}}
										</h5>
										<p>
											{{$tour->duration}} {{__('Days')}}
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
											{{__('Tour Type')}}
										</h5>
										<p>
											{{$tour->category ? $tour->category->name : ''}}
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
											{{__('Group Size')}}
										</h5>
										<p>
											{{$tour->tour_max_people}} {{__('persons')}}
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
											{{$tour->country->country}},{{$tour->state->state}}
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

	<!-- Single Details Area Start -->
	<section class="single-details">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="model-gallery-image">
						<div class="one-item-slider">
                            @foreach ($tour->gallery->where('imagable_id',$tour->id)->where('type','tour') as $gallery)
                            <div class="item"><img src="{{asset('assets/images/tour/gallery/'.$gallery->image)}}" alt="gallery-image"></div>
                            @endforeach
						</div>

						<ul class="all-item-slider">
                            @foreach ($tour->gallery->where('imagable_id',$tour->id)->where('type','tour') as $gel)
                            <li><img src="{{asset('assets/images/tour/gallery/'.$gel->image)}}" alt="gallery-image"></li>
                            @endforeach
						</ul>
					</div>
					<div class="overview-area">
						<h4 class="title">
							{{__('Overview')}} :
						</h4>
						<p>
						 <p>{!! $tour->description !!}</p>
						</p>
					</div>

					<div class="map-location-area">
						<h4 class="title">
							{{__("Tour's Location")}} : {{$tour->country->country}},{{$tour->state->state}},{{$tour->address}}
						</h4>
						<iframe
                            height="350"
                            frameborder="0" style="border:0; width: 100%;"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB1GpE4qeoJ__70UZxvX9CTMUTZRZNHcu8&&q={{ $tour->country->country }},{{$tour->state->state}},{{$tour->address}}" allowfullscreen>
                          </iframe>
					</div>

					@if($tour->include && $tour->exclude)
					<div class="map-location-area in-ex">
						<h4 class="title">
							{{__('Included/Excluded')}} :
						</h4>
						<div class="row">
							<div class="col-md-6">
								<ul>
									@foreach (explode(',,,',$tour->include) as $include)
									<li>{{$include}}</li>
									@endforeach
								</ul>
							</div>
							<div class="col-md-6">
								<ul>
									@foreach (explode(',,,',$tour->exclude) as $exclude)
									<li>{{$exclude}}</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
					@endif

					<div class="map-location-area itinerary ">
						@if($tour->inventorys->count() >0)
						<h4 class="title">
							{{__('Itinerary')}} :
						</h4>
						<div class="row">
							@foreach ($tour->inventorys as $inventory)
							<div class="col-md-6  mb-3">
                                <div class="card">
                                    <img class="card-img-top" src="{{asset('assets/images/tour/inventory-image/'.$inventory->image)}}" alt="Card image cap">
                                    <div class="card-body">
                                    <h5 class="card-title">{{$inventory->title}}</h5>
                                    <p class="card-text des mb-2">{{$inventory->description}}</p>
                                    <p class="card-text">{{$inventory->content}}</p>
                                    </div>
                                </div>
							</div>
							@endforeach
						</div>
						@endif

						@php
								$import = explode(',',implode(',',array_unique(explode(',',$tour->tour_attr_id))));
								 $combain = array_combine(explode(',',$tour->attr_term_id),explode(',',$tour->tour_attr_id));
								 $term = explode(',',$tour->attr_term_id);

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
                            $attr = App\Models\TourAttr::findOrFail($key);
                        @endphp
                        <div class="row p-0 t-extra-f">
                            <div class="col-lg-12">
                                <h4 class="title">
                                    {{$attr->name}} :
                                </h4>
                            </div>
                            <div class="col-md-12">
                            @foreach ($term_id as $term)
                            @php
                                $termName = App\Models\TourTerm::find($term)->name;
                            @endphp

                                <p class="l"><i class="far fa-check-circle"></i>{{$termName}}</p>

                            @endforeach
                        </div>
                        </div>
                        @endforeach



			        </div>
                    @if($tour->faq_title)
                    <div class="tour-faq-area">
                        <h4 class="title">
                            {{__('FAQs')}}
                        </h4>
                        <div class="accordion" id="tour-faq">
                            @foreach (explode(',,,',$tour->faq_title) as $id => $faq)
                            @php
                                $content = explode(',,,',$tour->faq_content);
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
                        {{__('Average Review : ')}} <span class="average_review">{{$tour->review()}}</span>
                        <ul class="review-list">
                            @forelse($reviews as $key => $review)
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
                                @empty
                                <p class="r-not-found">
                                    {{__('Review Not Found')}}
                                </p>

                            @endforelse
                        </ul>

                        @if(Auth::user() && App\Models\Order::where('user_id',Auth::user()->id)->where('item_id',$tour->id)->where('order_type','Tour')->exists())
                        @if(App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$tour->id)->exists())
                        <input type="hidden" id="now_review" value="{{App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$tour->id)->first()->review}}">
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
                                <input type="hidden" name="type" value="tour">
                                <input type="hidden" name="review_id" value="{{$tour->id}}">
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
                            @if($tour->discount)
                            <div class="discount">
                                {{$tour->discount}}%
                            </div>
                            @endif
                            <p class="price">
                            {{PriceHelper::showCurrencyPrice($tour->main_price)}}
                            @if($tour->sale_price)
                            <small><del>{{PriceHelper::showCurrencyPrice($tour->sale_price)}}</del></small>
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
                                    <input type="text" class="date-range date_check select-date" name="date" value="" />
                                </div>
                                @if($tour->is_person == 1 && $tour->person_type_price)
                                @foreach (explode(',,,',$tour->person_type) as $key => $type)
                                @php
                                    $person_price = explode(',,,',$tour->person_type_price)[$key];
                                    $person_max = explode(',,,',$tour->person_type_max)[$key];
                                    $person_min = explode(',,,',$tour->person_type_min)[$key];
                                @endphp
                                <div class="people-count">
                                    <div class="left">
                                        <h5 class="title">
                                            {{$type}}
                                        </h5>
                                        (<small>{{__('Per Person Price')}} {{PriceHelper::showCurrencyPrice($person_price)}}</small>)
                                    </div>
                                    <div class="right">
                                        <div class="qty">
                                            <ul>
                                                <li>
                                                    <span class=" abcd children_qtymins reducing" rel="{{$key}}" data-target="{{PriceHelper::showPrice($person_price)}}" data-href="{{$person_min}}">
                                                        <i class="fas fa-minus"></i>
                                                    </span>
                                                </li>
                                                <li>
                                                <span id="{{$key}}" data-target="{{PriceHelper::showPrice($person_price)}}" class="children_qty" data-href="{{$person_min}}"  data-price="{{$person_min * $person_price}}">{{$person_min}}</span>
                                                </li>
                                                <li>
                                                    <span class=" abcd children_qtyplus adding" data-href="{{$person_max}}"  data-target="{{PriceHelper::showPrice($person_price)}}" rel="{{$key}}">
                                                        <i class="fas fa-plus"></i>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                @if($tour->is_extra_price == 1)
                                <div class="extra-price-wizerd">
                                    <h5 class="title">
                                        {{__('Extra prices')}}:
                                    </h5>
                                    <ul class="extra-list">
                                        @foreach (explode(',,,',$tour->extra_price_name) as $key => $extra_price_name)
                                        @php
                                            $price = explode(',,,',$tour->extra_price);
                                            $type = explode(',,,',$tour->extra_price_type);
                                        @endphp
                                        <li>
                                            <div class="left">
                                            <input type="checkbox" id="s{{$key+1}}" data-href="{{PriceHelper::showPrice($price[$key])}}" class="tour_extra_prices" value="{{$key}}"> <label for="s{{$key+1}}">{{$extra_price_name}}</label>
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
                                            <h4 class="total">{{__('Total')}}:</h4>
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
                                if($tour->author_type == 'Admin'){
                                    $organizer =   App\Models\Admin::findOrFail(1);
                                }else{
                                    $organizer =	App\Models\User::findOrFail($tour->author_id);
                                }


                                @endphp
                                <div class="left">
                                    @if($tour->author_type =='Admin')
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

<input type="hidden" value="{{$tour->id}}" id="tourId">
<input type="hidden" value="{{$tour->duration}}" id="tourDoration">
<input type="hidden" value="{{$tour->tour_max_people}}" id="tourMaxPeapule">
<input type="hidden" value="{{PriceHelper::showPrice($tour->main_price)}}" id="tourMainPrice">
@include('front.inc.related')

@endsection

@section('script')
	<script src="{{asset('assets/front/js/tour/details.js')}}"></script>
@endsection
