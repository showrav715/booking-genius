    @extends('layouts.admin')
    
    @section('content')

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Create Post') }}
        <a href="{{ route('admin-blog-index') }}" class="btn back-btn btn-sm">{{__('Back')}}</a>
        </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin-blog-index')}}">{{ __('Blog') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Create Post') }}</li>
            </ol>
        </div>
        @include('includes.admin.form-error')
        @include('includes.admin.form-success')
        <div class="row">
            <div class="col-lg-12">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="row py-3">
                        <div class="col-md-6 image-area d-none text-center offset-3">
                            <img src="" class="img-fluid"  alt="image">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="gocover" style="background: url({{asset('assets/images/genarel-settings/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                        <form action="{{route('admin-blog-store')}}" enctype="multipart/form-data" method="POST" id="pageForm">
                            @csrf
                           
                            <div class="form-group">
                                <label for="title">{{ __('Blog Title') }}</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('Blog Title') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="categorys">{{ __('Category') }}</label>
                                        <select class="form-control  mb-3" id="categorys" name="category_id">
                                            <option value="" selected disabled>{{__('Select Category')}}</option>
                                            @foreach ($cats as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                      </div>        
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="video_image">{{ __('Post Thumbnail') }}</label>
                                        <span class="ml-3">{{ __('(support jpeg,jpg,png)') }}</span>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="photo" id="video_image" accept="image/*">
                                            <label class="custom-file-label" for="photo">{{ __('Choose file') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tag">{{ __('Tags') }}</label>
                                <input type="text" class="form-control" id="tag" name="tags" placeholder="{{ __('Tags') }}">
                            </div>

                            
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea id="area1" class="form-control nic-edit" name="description" placeholder="{{ __('Description') }}"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="source">{{ __('Source') }}</label>
                                <input type="text" class="form-control" name="source" id="source" placeholder="{{ __('Source') }}">
                            </div>

                            
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                  <input type="checkbox" class="custom-control-input" id="seo" >
                                  <label class="custom-control-label" for="seo"> {{ __('Allow Blog SEO') }}</label>
                                </div>
                              </div>

                            <div class="showbox d-none">
                                <div class="form-group">
                                    <label for="meta_tag">{{ __('Meta Tag') }}</label>
                                    <input type="text" class="form-control" id="meta_tag" name="meta_tag" placeholder="{{ __('Meta Tag') }}">
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">{{ __('Meta Description') }}</label>
                                    <textarea  class="form-control" rows="4" id="meta_description" name="meta_description" placeholder="{{ __('Meta Description') }}"></textarea>
                                </div>
                              </div>
                              
                            <button type="submit" id="insertButton" class="btn btn-primary">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" value="1" id="isValue">
    @endsection
