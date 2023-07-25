@extends('layouts.user')

@section('content')
<input type="hidden" id="page_id" value="1">
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Hotel') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('user-hotel-index')}}">{{ __('Hotel') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Hotel') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error') @include('includes.admin.form-success')
    <form action="{{route('user-hotel-update',$main->id)}}" enctype="multipart/form-data" method="POST" id="pageForm" >
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white ">{{__('Hotel Content')}}</div>
                    <div class="card-body">
                       
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input type="text" class="form-control" name="hotel_title" value="{{$main->title}}" id="title" placeholder="{{ __('Title') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Content') }}</label>
                            <textarea id="area1" class="form-control nic-edit" name="description" placeholder="{{ __('Description') }}">{{$main->description}} </textarea>
                        </div>

                        <div class="form-group">
                            <label for="video">{{ __('Video Link') }}</label>
                            <input type="text" class="form-control" name="video" value="{{$main->video}}" id="video" placeholder="{{ __('Video Link') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('Banner Image') }}</label>
                                    <div class="text-center banner_image_view mb-2">
                                        <img class="img-profile" src="{{$main->banner_image ? asset('assets/images/hotel-image/banner-image/'.$main->banner_image) : asset('assets/images/noimage.png')}}" >
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
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white ">{{__('Locations')}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">{{ __('Country') }}</label>
                            <input type="hidden" id="update_state_id" value="{{$main->state_id}}">
                            <select name="country_id" class="form-control" id="country">
                                <option value="" selected disabled>{{__('Select One')}}</option>
                                @foreach ($data['countries'] as $country)
                                <option value="{{$country->id}}" {{$country->id == $main->country_id ? 'selected' : ''}}>{{$country->country}}</option>
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
                            <input type="text" class="form-control" name="address" placeholder="{{__('Enter Address')}}" value="{{$main->address}}">
                        </div>
                    </div>
                </div>

                <div class="card mb-4 p-3">
                    <div class="card-header bg-primary text-white">{{__('Hotel Policy')}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="rating">{{ __('Hotel rating standard') }}</label>
                            <input type="number" class="form-control" name="rating" id="rating" placeholder="{{ __('Hotel rating standard') }}" value="{{$main->rating}}">
                        </div>

                        <p class="text-muted ml-3">{{__('Policy')}}</p>
                        <div class="row text-center mb-3">
                            <div class="col-6"><strong>{{__('Title')}}</strong></div>
                            <div class="col-6"><strong>{{__('Content')}}</strong></div>
                        </div>
                        <div id="policy-section">
                            @if($main->policy_title && $main->policy_content)
                            @foreach (explode(',,,',$main->policy_title) as $key => $policy)
                            <div class="language-area  position-relative">
                                <span class="remove-btn"><i class="fas fa-times"></i></span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-6">
                                        <div class="form-group ">
                                            <textarea name="title[]" class="form-control" placeholder="{{__('Enter Title')}}" required="">{{$policy}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-6">

                                        <div class="form-group ">
                                            <textarea name="content[]" class="form-control" placeholder="{{__('Enter Content')}}" required="">{{explode(',,,',$main->policy_content)[$key]}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="more-field text-center mb-3">
                            <button type="button" class="btn btn-info" id="policy-btn">{{ __('Add Item') }}</button>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 p-3">
                    <div class="card-header bg-primary text-white">{{__('Price')}}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="main_price">{{ __('Current Price') }} ({{PriceHelper::showCurrency()}})</label>
                                    <input type="text" class="form-control" name="main_price" value="{{PriceHelper::showAdminPrice($main->main_price)}}" id="main_price" placeholder="{{ __('Current Price') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sale_price">{{ __('Previous Price') }} ({{PriceHelper::showCurrency()}})</label>
                                    <input type="text" class="form-control" name="sale_price" value="{{PriceHelper::showAdminPrice($main->sale_price)}}" id="sale_price" placeholder="{{ __('Previous Price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="custom-control custom-switch my-3">
                            <input type="checkbox" id="extra-price" class="custom-control-input price-check" name="is_extra_price" value="1" {{$main->is_extra_price == 1 ? 'checked' : ''}}>
                            <label class="custom-control-label" for="extra-price">{{__('Enable extra price')}} ({{PriceHelper::showCurrency()}})</label>
                        </div>

                        <div class="show-extra-price {{$main->extra_price ? '' : 'd-none'}}">
                            <div id="price-section">
                                @if($main->extra_price) @foreach (explode(',,,',$main->extra_price) as $key => $extra_price) @php $nameprice = (explode(',,,',$main->extra_price_name)[$key]); $type = (explode(',,,',$main->extra_price_type)[$key]); @endphp
                                <div class="language-area  position-relative">
                                    <span class="price_remove-btn"><i class="fas fa-times"></i></span>
                                    <div class="row">
                                        <div class="col-sm-4 col-md-4 col-4">
                                            <div class="form-group ">
                                                <input name="extra_price_name[]" class="form-control" placeholder="{{__('Enter Name')}}" required="" value="{{$nameprice}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-4">
                                            <div class="form-group ">
                                                <input type="number" name="extra_price[]" class="form-control" placeholder="{{__('Enter Price')}}" required="" value="{{PriceHelper::showAdminPrice($extra_price)}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-4">
                                            <div class="form-group ">
                                                <select name="extra_price_type[]" class="form-control" required>
                                                    <option value="one_time" {{$type=='one_time' ? 'selected' : ''}}>{{__('One Time')}}</option>
                                                    <option value="dey" {{$type=='day' ? 'selected' : ''}}>{{__('Per Day')}}</option>
                                                    <option value="month" {{$type=='month' ? 'selected' : ''}}>{{__('Per Month')}}</option>
                                                    <option value="year" {{$type=='year' ? 'selected' : ''}}>{{__('Per Year')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach @endif
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
                                <option value="yes" {{$main->seo_check == 'yes' ? 'selected' : ''}}>{{__('Yes')}}</option>
                                <option value="no" {{$main->seo_check == 'no' ? 'selected' : ''}}>{{__('No')}}</option>

                            </select>
                        </div>
                        <div class="seo-show">
                            <div class="form-group">
                                <label for="meta_tag">{{ __('Meta Tag') }}</label>
                                <input type="text" class="form-control" id="tag" name="meta_tag" placeholder="{{ __('Meta Tag') }}" value="{{$main->meta_tag}}">
                            </div>

                            <div class="form-group">
                                <label for="meta_description">{{ __('Description') }}</label>
                                <textarea class="form-control" rows="4" id="meta_description" name="meta_description" placeholder="{{ __('Meta Description') }}">{{$main->meta_description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">{{__('Publish')}}</div>
                    <div class="card-body">
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="publish" name="status" class="custom-control-input" value="publish" checked>
                            <label class="custom-control-label" for="publish">{{__('Publish')}}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="draft" value="draft" name="status" class="custom-control-input">
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
                            <input type="checkbox" {{$main->is_feature == 1 ? 'checked' : ''}} class="custom-control-input" id="is_feature" name="is_feature" value="1">
                            <label class="custom-control-label" for="is_feature">{{__('Enable featured')}}</label>
                        </div>
                    </div>
                </div>

                @foreach ($data['hotalAttr'] as $attr)
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">{{$attr->name}}</div>
                    <div class="card-body">
                        <input type="checkbox" class="d-none" name="attr_id[]" value="{{$attr->id}}" id="attrIdCheck{{$attr->id}}"> @foreach ($attr->terms as $term)
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input term-check" rel="{{$term->hotel_attr_id}}" name="term_id[]" value="{{$term->id}},{{$term->hotel_attr_id}}" id="{{$term->id}}" {{in_array($term->id,explode(',',$main->attr_term_id)) ? 'checked' : ''}}>
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
                            <img class="img-profile" src="{{ asset('assets/images/hotel-image/'.$main->image->image)}}" >
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
                            @foreach ($main->gallery->where('type','hotel') as $key => $gallery)
                            <div class="col-sm-6">
                                <div class="img gallery-img"><span class="remove-img" data-href="{{route('hotel.gallery.image.remove',$gallery->id)}}"><i class="fas fa-times"></i><input type="hidden" value="{{$key}}"></span>
                                    <a href="{{asset('assets/images/hotel-image/room/'.$gallery->image)}}" target="_blank"><img src="{{asset('assets/images/hotel-image/room/'.$gallery->image)}}" alt="gallery image"></a>
                                </div>
                            </div>
                            @endforeach
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
<script src="{{asset('assets/user/js/hotel/create.js')}}"></script>

@endsection