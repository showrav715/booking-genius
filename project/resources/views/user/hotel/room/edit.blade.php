@extends('layouts.user')

@section('content')

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Room') }}
    <a href="{{ url()->previous() }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
    </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-dashboard')}}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('user-hotel-room',$data->hotel_id)}}">{{ __('Hotel Room') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Room') }}</li>
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
                    <form action="{{route('user-hotel-room-update',$data->id)}}" enctype="multipart/form-data" method="POST" id="pageForm">
                        @csrf
                       <input type="hidden" name="hotel_id" value="{{$data->hotel_id}}">
                        <div class="form-group">
                            <label for="title">{{ __('Room Title') }}</label>
                            <input type="text" class="form-control" name="room_name" id="title" placeholder="{{ __('Room Title') }}" value="{{$data->room_name}}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bed">{{ __('Bed No') }}</label>
                                    <input type="number" class="form-control" value="{{$data->bed}}" name="bed" id="bed" placeholder="{{ __('Bed No') }}">
                                </div>
                            </div>
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="square_fit">{{ __('Square Fit') }}</label>
                                    <input type="number" class="form-control" value="{{$data->square_fit}}" name="square_fit" id="square_fit" placeholder="{{ __('Square Fit') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adult">{{ __('Adult') }}</label>
                                    <input type="number" class="form-control" value="{{$data->adult}}" name="adult" id="adult" placeholder="{{ __('Adult') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="children">{{ __('Children') }}</label>
                                    <input type="number" class="form-control" name="children" id="children" placeholder="{{ __('Children') }}" value="{{$data->children}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">{{ __('Stock Room') }}</label>
                                <input type="number" class="form-control" name="stock" value="{{$data->stock}}" id="stock" placeholder="{{ __('Stock Room') }}">
                            </div>
                        </div>
                      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pernightcost">{{ __('Per Night Cost') }} ({{PriceHelper::showCurrency()}})</label>
                                <input type="number" min="0" step="0.1" class="form-control" name="per_night_cost" id="per_night_cost" placeholder="{{ __('Per Night Cost') }}" value="{{PriceHelper::showAdminPrice($data->per_night_cost)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">{{ __('Room Type') }}</label>
                                <select name="type" class="form-control" id="type">
                                    <option value="non_ac_room" {{$data->type == 'non_ac_room' ? 'selected' : ''}}>{{__('Non Ac Room')}}</option>
                                    <option value="ac_room" {{$data->type == 'ac_room' ? 'selected' : ''}}>{{__('Ac Room')}}</option>
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
<div class="modal fade" id="setgallery" tabindex="-1" role="dialog"     aria-labelledby="setgallery" aria-hidden="true">
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
                            @foreach ($data->gallery->where('type','hotel_room') as $key => $gallery)
                            <div class="col-sm-6">
                                <div class="img gallery-img"><span class="remove-img" data-href="{{route('hotel.room.image.remove',$gallery->id)}}"><i class="fas fa-times"></i><input type="hidden" value="{{$key}}"></span>
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

<script>
    // ============= Gallery Section Insert Start ==================

    $(document).on('click', '.remove-img', function () {
		var id = $(this).find('input[type=hidden]').val();
        var rmvUrl = $(this).attr('data-href');
        if(rmvUrl){
            $.get(rmvUrl,function(res){
                $.notify(res.message,'success');
            })
        }
		$('#galval' + id).remove();
		$(this).parent().parent().remove();
	});

    $(document).on('click', '#prod_gallery', function () {
            $('#uploadgallery').click();
            $('.selected-image .row').html('');
            $('#pageForm').find('.removegal').val(0);
        });


	$("#uploadgallery").change(function () {
		var total_file = document.getElementById("uploadgallery").files.length;
		for (var i = 0; i < total_file; i++) {
			$('.selected-image .row').append('<div class="col-sm-6">' +
				'<div class="img gallery-img">' +
				'<span class="remove-img"><i class="fas fa-times"></i>' +
				'<input type="hidden" value="' + i + '">' +
				'</span>' +
				'<a href="' + URL.createObjectURL(event.target.files[i])+ '" target="_blank">' +
				'<img src="' + URL.createObjectURL(event.target.files[i])+ '" alt="gallery image">'+
				'</a>'+
				'</div>'+
				'</div>'
			);
			$('#pageForm').append('<input type="hidden" name="galval[]" id="galval'+i +'" class="removegal" value="'+i+'">')
		}

	});

// ============= Gallery Section Insert End ==================
</script>

@endsection