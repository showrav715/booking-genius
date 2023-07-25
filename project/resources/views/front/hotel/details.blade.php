@extends('layouts.front')
@section('title')
	{{__('Hotel Details')}} | {{$gs->website_title}}
@endsection


@if($hotel->meta_tag != null || $hotel->meta_description != null)
@section('meta_content')
<meta property="og:title" content="{{$hotel->title}}" />
<meta property="og:description" content="{{ $hotel->meta_description != null ? $hotel->meta_description : strip_tags($hotel->meta_description) }}" />
<meta property="og:image" content="{{asset('assets/images/hotel-image/'.$hotel->image->image)}}" />
<meta name="keywords" content="{{ $hotel->meta_tag }}">
<meta name="description" content="{{ $hotel->meta_description }}">

@endsection
@endif


@section('content')
	<!-- Tour Details Banner Start -->
    <section class="tour-details-banner" style="background: url({{asset('assets/images/hotel-image/banner-image/'.$hotel->banner_image)}})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content">
                        <div class="left">
                            <h4 class="title">
                                {{$hotel->title}}
                            </h4>

                        </div>
                        @if($hotel->video)
                        <div class="right-video">
                            <a href="{{$hotel->video}}" class="video-play-btn mfp-iframe">
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
                    <div class="info-content info-content-hotel">
                        <div class="review-box">
                            <div class="rating">
                                {{$hotel->review()}} <small>/5</small>
                            </div>
                            <div class="review">
                                {{$hotel->review_count() }} {{__('Review')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tour Top info Area Start -->


    <!-- Single Details Area Start -->
    <section class="single-details hotel">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
					@if($hotel->gallery->count() > 0)
                    <div class="model-gallery-image">
                        <div class="one-item-slider">
							@foreach ($hotel->gallery->where('type','hotel')->where('imagable_id',$hotel->id) as $gal_image)
                            <div class="item"><img src="{{asset('assets/images/hotel-image/gallery/'.$gal_image->image)}}" alt="gallery-image"></div>

							@endforeach
                        </div>
                        <ul class="all-item-slider">
							@foreach ($hotel->gallery->where('type','hotel')->where('imagable_id',$hotel->id) as $gal_image)
							<li><img src="{{asset('assets/images/hotel-image/gallery/'.$gal_image->image)}}" alt="gallery-image"></li>
							@endforeach

                        </ul>
					</div>
					@endif
                    <div class="overview-area">
                        <h4 class="title">
                            {{__('Overview')}} :
                        </h4>
                        <p>{!! $hotel->description !!}</p>
                    </div>
                    @if($hotel->rooms->count() > 0)
                    <div class="available-rooms">
                        <h4 class="title">
                            {{__('Available Rooms')}} :
                        </h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="room-option">
                                    <div class="row">
                                        <div class="r-s-option col-lg-6 check-in">
                                            <p>{{__('Check In - Out')}}</p>
                                            <input type="text" class="date-range date_range" name="daterange" value="" />
                                        </div>
                                        <div class="r-s-option col-lg-3 guests">
                                            <p>{{__('Guests')}}</p>
                                            <div class="drop-down-select-guests">
                                                <div class="people-count">
                                                    <div class="left">
                                                        <h5 class="title">
                                                            {{__('Adults')}}
                                                        </h5>
                                                    </div>
                                                    <div class="right">
                                                        <div class="qty">
                                                            <ul>
                                                                <li>
                                                                    <span class="qtymins reducing">
                                                                        <i class="fas fa-minus"></i>
                                                                    </span>
                                                                </li>
                                                                <li>
                                                                    <span class="adultqty">0</span>
                                                                </li>
                                                                <li>
                                                                    <span class="qtyplus adding">
                                                                        <i class="fas fa-plus"></i>
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="people-count">
                                                    <div class="left">
                                                        <h5 class="title">
                                                            {{__('Children')}}
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
                                                                    <span class="children_qty">0</span>
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
                                            </div>
                                        </div>
                                        <div class="r-s-option col-lg-3 check-availability">
                                            <a href="javascript:;" id="check_avalibabity">
                                                {{__('Check Avalilabity')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="all-rooms" id="room_view_search">
                            @foreach ($hotel->rooms as $room)
                            <div class="single-room">
                                <div class="image" data-toggle="modal" data-target="#staticBackdrop">
                                    @if (count($room->gallery->where('type','hotel_room')) > 0)
                                    <img src="{{asset('assets/images/hotel-image/room/'.$room->gallery->where('type','hotel_room')[0]->image)}}" alt="">
                                    @else
                                    <img src="{{asset('assets/images/placeholder.jpg')}}" alt="">
                                    @endif

                                    <div class="count-gallery"><i class="fas fa-image"></i>
                                        {{count($room->gallery->where('type','hotel_room')->where('imagable_id',$room->id))}}
                                    </div>
                                </div>
                                <div class="hotel-info">
                                    <h3 class="room-name">{{$room->room_name}}</h3>
                                    <ul class="room-meta">
                                        <li>
                                            <div class="item">
                                                <i class="fas fa-compass"></i>
                                                <span>{{$room->square_fit}} {{__('sqft')}}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item">
                                                <i class="fas fa-bed"></i>
                                                <span>x{{$room->bed}} {{__('bed')}}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item"><i class="fas fa-users"></i>
                                            <span>x {{$room->adult}} {{__('Adult')}}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item"><i class="fas fa-child fa"></i>
                                                <span>x{{$room->children}} {{__('Children')}}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <!-- Button trigger modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false"
                            tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">{{__('Room Gallery')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="model-gallery-image">
                                            <div class="model-slider">
                                                @foreach ($room->gallery->where('type','hotel_room') as $gallery)
                                                    <div class="item"><img src="{{asset('assets/images/hotel-image/room/'.$gallery->image)}}" alt=""></div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hotel_room_book_status">
                            @if($hotel->extra_price_name && $hotel->extra_price && $hotel->extra_price_type)
                            <div class="row row_extra_service">
                                <div class="col-md-12">
                                    <div class="form-section-group"><label>{{__('Facilities')}}:</label>
                                        <div class="row">
                                            @foreach (explode(',,,',$hotel->extra_price_name) as $key => $extra_item)
                                            @php
                                                $price = explode(',,,',$hotel->extra_price);
                                                $type = explode(',,,',$hotel->extra_price_type);
                                            @endphp
                                            <div class="col-md-6 extra-item">
                                                <div class="extra-price-wrap d-flex justify-content-between">
                                                    <div class="flex-grow-1"><label><input type="checkbox" data-href="{{PriceHelper::showPrice($price[$key])}}" class="extra_prices"  value="{{$key}}"> {{$extra_item}}
                                                        <div class="render">({{$type[$key]}})</div></label></div>
                                                    <div class="flex-shrink-0">{{PriceHelper::showCurrency()}} {{PriceHelper::showPrice($price[$key]) }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row row_total_price">
                                <div class="col-md-6">
                                    <div class="extra-price-wrap d-flex justify-content-between">
                                        <div class="flex-grow-1"><label>
                                                {{__('Total Room')}}:
                                            </label></div>
                                        <div class="flex-shrink-0 total_room">
                                            0
                                        </div>
                                    </div>
                                    <div class="extra-price-wrap d-flex justify-content-between">
                                        <div class="flex-grow-1"><label>
                                                {{__('Service fee')}}
                                                 <i data-toggle="tooltip" data-placement="top" title=""
                                                    class="icofont-info-circle"
                                                    data-original-title="This helps us run our platform and offer services like 24/7 support on your trip."></i></label>
                                        </div>
                                        <div class="flex-shrink-0"><span>{{PriceHelper::showCurrency()}} </span> <span class="service_fee" data-href="{{PriceHelper::showPrice($gs->hotel_service_fee)}}">{{PriceHelper::showPrice($gs->hotel_service_fee)}}</span>
                                        </div>
                                    </div>
                                    <div class="extra-price-wrap d-flex justify-content-between is_mobile">
                                        <div  class="flex-grow-1"><label>
                                                {{__('Facilities')}}:
                                            </label></div>
                                        <div class="total-room-price"><span>{{PriceHelper::showCurrency()}} </span> <span class="facilities_price"> 0.00 </span></div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="control-book">
                                        <div class="total-room-price"><span> {{__('Total Price')}}:</span> <span>{{PriceHelper::showCurrency()}}</span><span class="total_price">0.00</span>
                                        </div>
                                         <button type="button" class="mybtn1 book_button"><span>{{__('Book
                                                Now')}}</span> <i class="fa fa-spinner fa-spin"
                                                style="display: none;"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="map-location-area">
						<h4 class="title">
							{{__("Tour's Location")}} :
						</h4>
						<iframe
                            height="350"
                            frameborder="0" style="border:0; width: 100%;"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB1GpE4qeoJ__70UZxvX9CTMUTZRZNHcu8&q={{ $hotel->country->country }},{{$hotel->state->state}},{{$hotel->address}}" allowfullscreen>
                        </iframe>
                    </div>
                    @if($hotel->policy_title)
                    <div class="tour-faq-area">
						<h4 class="title">
							{{__('Policy')}}
						</h4>
						<div class="accordion" id="tour-faq">
                            @foreach (explode(',,,',$hotel->policy_title) as $id => $policy_title)
                            @php
                                $content = explode(',,,',$hotel->policy_content);
                            @endphp
                            <div class="single-accordion">
                                <div class="accordion-header">
                                    <h4 class="title" data-toggle="collapse" data-target="#collapse{{$id}}" aria-expanded="true" aria-controls="collapseOne">
                                       <img src="{{asset('assets/front/images/question.png')}}" alt="">{{$policy_title}}
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
                        @if(Auth::user() && App\Models\Order::where('user_id',Auth::user()->id)->where('item_id',$hotel->id)->where('order_type','Hotel')->exists())

						@if(App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$hotel->id)->exists())
						<input type="hidden" id="now_review" value="{{App\Models\Review::where('user_id',Auth::user()->id)->where('review_id',$hotel->id)->first()->review}}">
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
							{{__('Average Review : ')}} <span class="average_review">{{$hotel->average_review}}</span>
						</div>
						<div class="write-comment-area">
							<form action="{{route('front.review.store')}}" method="POST" id="reviewForm">
								@csrf
								<input type="hidden" name="review" id="reviewValue" value="">
								<input type="hidden" name="type" value="hotel">
								<input type="hidden" name="review_id" value="{{$hotel->id}}">
								<div class="row">
									<div class="col-lg-12">
										<textarea name="comment" placeholder="{{__('Your ~Review')}} *"></textarea>
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

                        @php
                        $import = explode(',',implode(',',array_unique(explode(',',$hotel->hotel_attr_id))));
                         $combain = array_combine(explode(',',$hotel->attr_term_id),explode(',',$hotel->hotel_attr_id));
                         $term = explode(',',$hotel->attr_term_id);

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
                            $attr = App\Models\HotelAttr::findOrFail($key);
                        @endphp
                        <div class="facilities-wizerd">
                            <h4 class="title">
                                {{$attr->name}}
                            </h4>
                            <ul class="facilities-list">
                                @foreach ($term_id as $term)
                                @php
                                    $ter = App\Models\AttrTrem::find($term);
                                @endphp
                                <li>
                                    <img width="40" src="{{asset('assets/images/attr-term-image/'.$ter->image->image)}}" alt=""> {{$ter->name}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                       @endforeach
                       <div class="organize-by">
                        <h4 class="title">
                                {{__('Organized by')}}
                        </h4>
                        <div class="organizer-profile">
                            @php
                            if($hotel->author_type == 'Admin'){
                                $organizer =   App\Models\Admin::findOrFail(1);
                            }else{
                                $organizer =	App\Models\User::findOrFail($hotel->author_id);
                            }

                            @endphp
                            <div class="left">
                                @if($hotel->author_type =='Admin')
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

    <input type="hidden" id="showCurrency" value="{{PriceHelper::showCurrency()}}">
    <input type="hidden" id="hotel_id_ajax" value="{{$hotel->id}}">
    <input type="hidden" id="hotel_search_ajax" value="{{route('hotel.room.search')}}">
    @include('front.inc.related')
    <!-- Trending Tour Area End -->
@endsection


@section('script')
<script src="{{asset('assets/front/js/hotel/details.js')}}"></script>
@endsection
