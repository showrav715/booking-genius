@extends('layouts.user')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create Car') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-car-index')}}">{{ __('Car') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Create Car') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error') @include('includes.admin.form-success')
    <form action="{{route('user-car-store')}}" enctype="multipart/form-data" method="POST" id="pageForm">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white ">{{__('Car Content')}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('Title') }}">
                        </div>
                        
                       
                        <div class="form-group">
                            <label for="description">{{ __('content') }}</label>
                            <textarea id="area1" class="form-control nic-edit" name="description" placeholder="{{ __('Description') }}"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="video">{{ __('Youtube Video') }}</label>
                            <input type="text" id="video" class="form-control" placeholder="{{__('Enter Youtube Video Link')}}" name="video">
                        </div>

                        <p class="text-muted mt-2">{{__('FAQS')}}</p>
                        <div class="row text-center mb-3">
                            <div class="col-6 border py-2"><strong>{{__('Title')}}</strong></div>
                            <div class="col-6 border py-2"><strong>{{__('Content')}}</strong></div>
                        </div>
                        <div id="faq-section">
                        </div>
                        <div class="more-field text-right mb-3">
                            <button type="button" class="btn btn-info" id="faq-btn">{{ __('Add Item') }}</button>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('Banner Image') }}</label>
                                    <div class="text-center banner_image_view mb-2">
                                        <img class="img-profile" src="{{asset('assets/images/noimage.png')}}" >
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input banner_image" name="banner_image">
                                        <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="gallery[]" class="d-none" id="uploadgallery" accept="image/*"	multiple>
                            <label for="title" class="d-block">{{ __('Gallery') }}</label>
                            <a href="#" class="set-gallery btn btn-primary" data-toggle="modal" data-target="#setgallery">
                                <i class="icofont-plus"></i> {{ __('Set Gallery') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 p-3">
                    <div class="card-header bg-primary text-white">{{__('Extra Information')}}</div>
                    <div class="card-body">
                        <div class="row border-buttom">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="passenger">{{ __('Passenger') }}</label>
                                    <input type="number" class="form-control" name="passenger" id="bed" placeholder="{{ __('Passenger') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gear">{{ __('Gear Shift') }}</label>
                                    <input type="text" class="form-control" name="gear" id="gear" placeholder="{{ __('Gear Shift') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="baggage">{{ __('Baggage') }}</label>
                                    <input type="number" class="form-control" name="baggage" id="baggage" placeholder="{{ __('Baggage') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="door">{{ __('Door') }}</label>
                                    <input type="number" class="form-control" name="door" id="door" placeholder="{{ __('Door') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white ">{{__('Locations')}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">{{ __('Country') }}</label>
                            <select name="country_id" class="form-control" id="country">
                                <option value="" selected disabled>{{__('Select One')}}</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->country}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">{{ __('State') }}</label>
                            <select name="state_id" class="form-control" id="state">
                               <option value="">{{__('State')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Adddress') }}</label>
                            <input type="text" class="form-control" name="address" placeholder="{{__('Enter Address')}}">
                        </div>
                    </div>
                </div>

                <div class="card mb-4 p-3">
                    <div class="card-header bg-primary text-white">{{__('Price')}}</div>
                    <div class="card-body">
                        <div class="row border-buttom">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="number">{{ __('Number') }}</label>
                                    <input type="number" class="form-control" name="number" id="number" placeholder="{{ __('Number') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">{{ __('Current Price') }} ({{PriceHelper::showCurrency()}})</label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="{{ __('Current Price') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sale_price">{{ __('Previous Price') }} ({{PriceHelper::showCurrency()}})</label>
                                    <input type="number" class="form-control" name="sale_price" id="sale_price" placeholder="{{ __('Previous Price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="custom-control custom-switch my-3">
                            <input type="checkbox" id="extra-price" class="custom-control-input price-check" name="is_extra_price" value="1">
                            <label class="custom-control-label" for="extra-price">{{__('Enable extra price')}} ({{PriceHelper::showCurrency()}})</label>
                        </div>

                        <div class="show-extra-price d-none">
                            <div id="price-section">

                            </div>
                            <div class="more-field text-center mb-3">
                                <button type="button" class="btn btn-info" id="price-btn">{{ __('Add Price') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 p-3">
                    <div class="card-header bg-primary text-white">{{__('Seo Manager')}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="rating">{{ __('Allow search engines to show this service in search results?') }}</label>
                            <select name="seo_check" class="form-control form-control-sm seoCheck">
                                <option value="yes" selected>{{__('Yes')}}</option>
                                <option value="no">{{__('No')}}</option>
                            </select>
                        </div>
                        <div class="seo-show">
                            <div class="form-group">
                                <label for="meta_tag">{{ __('Meta Title') }}</label>
                                <input type="text" class="form-control" id="meta_tag" name="meta_title" placeholder="{{ __('Meta Title') }}" placeholder="{{__('Enter Meta Title')}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_tag">{{ __('Meta Tag') }}</label>
                                <input type="text" class="form-control" id="tag" name="meta_tag" placeholder="{{ __('Meta Tag') }}">
                            </div>

                            <div class="form-group">
                                <label for="meta_description">{{ __('Description') }}</label>
                                <textarea class="form-control" rows="4" id="meta_description" name="meta_description" placeholder="{{ __('Meta Description') }}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">{{__('Publish')}}</div>
                    <div class="card-body">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="draft" value="draft" checked name="status" class="custom-control-input">
                            <label class="custom-control-label" for="draft">{{__('Draft')}}</label>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-outline-primary mb-1 mt-1">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                </div>


                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">{{__('Availability')}}</div>
                    <div class="card-body">
                        <p>{{__('Hotel Featured')}}</p>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_feature" name="is_feature" value="1">
                            <label class="custom-control-label" for="is_feature">{{__('Enable featured')}}</label>
                        </div>
                    </div>
                </div>

                @foreach ($car_attrs as $attr)
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">{{$attr->name}}</div>
                    <div class="card-body">
                        <input type="checkbox" class="d-none" name="attr_id[]" value="{{$attr->id}}" id="attrIdCheck{{$attr->id}}"> @foreach ($attr->terms as $term)
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input term-check" rel="{{$term->car_attr_id}}" name="term_id[]" value="{{$term->id}},{{$term->car_attr_id}}" id="{{$term->id}}">
                            <label class="custom-control-label" for="{{$term->id}}">{{$term->name}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">{{__('Feature Image')}}</div>
                    <div class="card-body">
                        <div class="text-center image-view mb-4">
                            <img class="img-profile" src="{{asset('assets/images/noimage.png')}}" >
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input image" name="image">
                            <label class="custom-file-label" for="image">{{ __('Choose file') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Image Gallery') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="top-area">
					<div class="row">
						<div class="col-sm-6 text-right">
							<div class="upload-img-btn">
								<label for="image-upload" id="prod_gallery"><i
										class="icofont-upload-alt"></i>{{ __('Upload File') }}</label>
							</div>
						</div>
						<div class="col-sm-6">
							<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i
									class="fas fa-check"></i> {{ __('Done') }}</a>
						</div>
						<div class="col-sm-12 text-center">( <small>{{ __('You can upload multiple Images.') }}</small>
							)</div>
					</div>
				</div>
				<div class="gallery-images">
					<div class="selected-image">
						<div class="row">


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" value="1" id="isValue">
@endsection

@section('script')
<script src="{{asset('assets/user/js/car/create.js')}}"></script>


@endsection