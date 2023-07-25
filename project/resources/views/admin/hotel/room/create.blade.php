@extends('layouts.admin')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create Room') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-hotel-room',$hotel_id)}}">{{ __('Hotel Room') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Create Room') }}</li>
        </ol>
    </div>
    @include('includes.admin.form-error')
    @include('includes.admin.form-success')
    <div class="row">
        <div class="col-lg-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form action="{{route('admin-hotel-room-store')}}" enctype="multipart/form-data" method="POST" id="pageForm">
                        @csrf
                       <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                        <div class="form-group">
                            <label for="title">{{ __('Room Title') }}</label>
                            <input type="text" class="form-control" name="room_name" id="title" placeholder="{{ __('Room Title') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bed">{{ __('Number of beds') }}</label>
                                    <input type="number" class="form-control" name="bed" id="bed" placeholder="{{ __('Number of beds') }}">
                                </div>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="square_fit">{{ __('Room Size') }} <small>{{__('(square fit}')}}</small></label>
                                    <input type="text" class="form-control" name="square_fit" id="square_fit" placeholder="{{ __('Room Size') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="extra_square">{{ __('Max Adults') }}</label>
                                    <input type="number" class="form-control" name="adult" id="adult" placeholder="{{ __('Max Adults') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="children">{{ __('Max Children') }}</label>
                                    <input type="number" class="form-control" name="children" id="children" placeholder="{{ __('Max Children') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">{{ __('Number of room') }}</label>
                                <input type="number" class="form-control" name="stock" id="stock" placeholder="{{ __('Number of room') }}">
                            </div>
                        </div>
                     
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pernightcost">{{ __('Per Night Price') }} ({{PriceHelper::showCurrency()}})</label>
                                <input type="number" class="form-control" name="per_night_cost" id="per_night_cost" placeholder="{{ __('Per Night Price') }}">
                            </div>
                          </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">{{ __('Room Type') }}</label>
                                <select name="type" class="form-control" id="type">
                                    <option value="non_ac_room">{{__('Non Ac Room')}}</option>
                                    <option value="ac_room">{{__('Ac Room')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="file" name="gallery[]" class="d-none" id="uploadgallery" accept="image/*"	multiple>
                            <label for="title" class="d-block">{{ __('Gallery') }}</label>
                            <a href="javascript:;" class="set-gallery btn btn-primary" data-toggle="modal" data-target="#setgallery">
                                <i class="icofont-plus"></i> {{ __('Set Gallery') }}
                            </a>
                        </div>
                       
                        </div>
                        <button type="submit" id="insertButton" class="btn btn-primary">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
 <script src="{{asset('assets/admin/js/hotel/hotel.js')}}"></script>
@endsection