@extends('layouts.front')
@section('title')
	{{__('Spaces')}} | {{$gs->website_title}}
@endsection
@section('content')
	<!--Main Breadcrumb Area Start -->
	<div class="main-breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="pagetitle">
						{{__('All Spaces')}}
					</h1>
					<ul class="pages">
						<li>
							<a href="{{route('front.index')}}">
								{{__('Home')}}
							</a>
						</li>
						<li class="active">
							<a href="{{route('front.spaces')}}">
								{{__('Space')}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--Main Breadcrumb Area End -->

	<!-- sub-categori Area Start -->
	<section class="sub-categori">
		<div class="container">
			<div class="row check_position">
				<div class="ajax_loader" style="background: url({{asset('assets/images/genarel-settings/'.$gs->website_loader)}}) no-repeat scroll center center rgba(0,0,0,.6);"></div>
				@includeIf('front.inc.searching_sitebar')
				<div class="col-lg-9 order-first order-lg-last">
					<div class="right-area">
						@include('front.inc.filter_section')
						@if($spaces->count() > 0)
						<div class="categori-item-area" id="space_ajax_load">
							<div class="row">
									@foreach ($spaces as $space)
									<div class="col-lg-4 col-md-6">
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
												<img src="{{asset('assets/images/space/feature-image/'.$space->image->image)}}" alt="space-feature">
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
													
												</div>
											</div>
										</div>
									</div>
									@endforeach
							</div>
							{{ $spaces->appends(['minprice' => request()->input('minprice'), 'maxprice' => request()->input('maxprice'), 'country_id' => request()->input('country_id'), 'sort' => request()->input('sort'), 'review' => request()->input('review'),'view' => request()->input('view')])->links() }}
						</div>
						@else
							<h4 class="text-center">{{__('Space Not Found')}}</h4>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- sub-categori Area End -->

	<form id="spaces" class="d-none" action="{{route('front.spaces')}}" method="GET">
		<input type="text" class="country" 	name="country_id" 	value="{{request()->input('country_id') ? 	request()->input('country_id') : '' }}">
		<input type="text" class="review" 	name="review" 	value="{{request()->input('review') ? 	request()->input('review') : '' }}">
		<button type="submit" id="search-tour"></button>
	</form>

	<input type="hidden" value="{{request()->input('country_id')}}" id="country_id_ajax">
	<input type="hidden" value="{{request()->input('review')}}" id="reviewajax">
	<input type="hidden" value="{{request()->input('minPrice')}}" id="minPriceajax">
	<input type="hidden" value="{{request()->input('maxPrice')}}" id="maxPriceajax">
	<input type="hidden" value="{{request()->input('view')}}" id="viewajax">

@endsection

@section('script')
	<script src="{{asset('assets/front/js/space/index.js')}}"></script>
@endsection