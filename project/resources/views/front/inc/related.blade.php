@if($related_data->count() > 0)
@if($data_type == 'tour')
	<!-- Trending Tour Area Start -->
	<section class="tranding-tour">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-area">
                        <h4 class="title">
                                {{__('Related Tours')}}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tour-slider">
                        @foreach($related_data as $tour)
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
                                        <div class="right-area">
                                            <div class="time-counter">
                                                    <div data-countdown="2020/05/01"></div>
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
@if($data_type == 'car')
	<!-- Trending Tour Area Start -->
	<section class="tranding-tour">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-area">
                        <h4 class="title">
                                {{__('Related Cars')}}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tour-slider">
                        @foreach($related_data as $car)
                        <div class="slide-item">
                            <div class="single-tours">
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
                                    <img src="{{asset('assets/images/car/feature-image/'.$car->image->image)}}" alt="tour-feature">
                                </div>
                                <div class="content">
                                    <span class="add-favotite corsor-pointer" data-href="{{route('front.favarite',$car->id.',,tour')}}">
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
                                        <div class="right-area">
                                            <div class="time-counter">
                                                    <div data-countdown="2020/05/01"></div>
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
@if($data_type == 'space')
	<!-- Trending Tour Area Start -->
	<section class="tranding-tour">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-area">
                        <h4 class="title">
                                {{__('Related Space')}}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tour-slider">
                        @foreach($related_data as $space)
                        <div class="slide-item">
                            <div class="single-tours">
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
                                    <img src="{{asset('assets/images/space/feature-image/'.$space->image->image)}}" alt="tour-feature">
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
                                                @if($space->sale_price)
                                                 <small><del>{{PriceHelper::showCurrencyPrice($space->sale_price)}}</del></small>
                                                 @endif
                                            </div>
                                        </div>
                                        <div class="right-area">
                                            <div class="time-counter">
                                                    <div data-countdown="2020/05/01"></div>
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
@if($data_type == 'hotel')
	<!-- Trending Tour Area Start -->
	<section class="tranding-tour">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-area">
                        <h4 class="title">
                                {{__('Related Hotels')}}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tour-slider">
                        @foreach($related_data as $hotel)
                        <div class="slide-item">
                            <div class="single-tours">
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
                                    <img src="{{asset('assets/images/hotel-image/'.$hotel->image->image)}}" alt="tour-feature">
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
                                        <div class="right-area">
                                            <div class="time-counter">
                                                    <div data-countdown="2020/05/01"></div>
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
@endif