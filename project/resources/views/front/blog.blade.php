@extends('layouts.front')

@section('title')
	{{__('Blogs | ')}} {{$gs->website_title}}
@endsection

@section('content')
    <!--Main Breadcrumb Area Start -->
	<div class="main-breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="pagetitle">
						{{__('Blog')}}
					</h1>
					<ul class="pages">
						<li>
							<a href="{{route('front.index')}}">
								{{__('Home')}}
							</a>
						</li>
						<li class="active">
                        <a href="{{route('front.blog')}}">
								{{__('Blog')}}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--Main Breadcrumb Area End -->

	<!-- Blog Area Start -->
	<section class="blog blog-page" id="blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="row">
                        @foreach ($blogs as $blog)
                        <div class="col-md-6">
							<a href="{{ route('front.blog.show',$blog->slug) }}" class="single-blog">
								<div class="img">
									<img src="{{asset('assets/images/blogs/'.$blog->image->image)}}" alt="">
								</div>
								<div class="content">
									<span>
										<h4 class="title">
											{{$blog->title}}
										</h4>
									</span>
									<div class="text">
										<p>
                                            {{substr(strip_tags($blog->description),0, 200)}}
										</p>
									</div>
								
									<ul class="top-meta">
											<li>
												<span>
                                                    <i class="far fa-clock"></i>{{Carbon\Carbon::parse($blog->created_at)->diffForHumans()}}
												</span>
											</li>
										</ul>
								</div>
							</a>
						</div>
                        @endforeach
					</div>	
				</div>
				<div class="col-lg-4">
					<div class="blog-aside">
						<div class="serch-widget">
							<h4 class="title">
								{{__('Search')}}
							</h4>
							<form action="#">
								<input type="text" placeholder="{{__('Search')}}">
								<button class="submit" type="submit">{{__('Search')}}</button>
							</form>
						</div>
						<div class="categori">
							<h4 class="title">{{__('Categories')}}</h4>
							<ul class="categori-list">
								@foreach($bcats as $cat)
                                    @if($cat->blogs()->count() != 0)
                                        <li>
                                            <a href="{{ route('front.blogcategory',$cat->slug) }}" {{ $cat->id == $blog->category_id ? 'class="active"':'' }}>
                                                <span>{{ $cat->name }}</span>
                                                <span>({{ $cat->blogs()->count() }})</span>
                                            </a>
                                        </li>
                                        @endif
                                    @endforeach
							</ul>
						</div>
						<div class="recent-post-widget">
							<h4 class="title">{{__('Recent Post')}}</h4>
							<ul class="post-list">
								@foreach (App\Models\Blog::orderBy('created_at', 'desc')->limit(4)->get() as $blog)
                                <li>
                                    <div class="post">
                                        <div class="post-img">
                                            <img style="width: 73px; height: 59px;" src="{{ asset('assets/images/blogs/'.$blog->image->image) }}" alt="blog image">
                                        </div>
                                        <div class="post-details">
                                            <a href="{{ route('front.blog.show',$blog->slug) }}">
                                                <h4 class="post-title">
                                                    {{strlen($blog->title) > 45 ? substr($blog->title,0,45)." .." : $blog->title}}
                                                </h4>
                                            </a>
                                            <p class="date">
                                                {{ date('M d - Y',(strtotime($blog->created_at))) }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
							</ul>
                        </div>
                     
						<div class="tags">
							<h4 class="title">{{__('Tags')}}</h4>
							<span class="separator"></span>
							<ul class="tags-list">
                                @foreach($tags as $tag) @if(!empty($tag))
                                <li>
                                    <a href="{{ route('front.blogtags',$tag) }}">{{ $tag }} </a>
                                </li>
                                @endif @endforeach
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Blog Area End-->
@endsection