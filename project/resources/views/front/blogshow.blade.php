@extends('layouts.front')
@section('title')
	{{__('Blogs | ')}} {{$gs->website_title}}
@endsection


@if($blog->meta_tag != null || $blog->meta_description != null)
@section('meta_content')
<meta property="og:title" content="{{$blog->title}}" />
<meta property="og:description" content="{{ $blog->meta_description != null ? $blog->meta_description : strip_tags($blog->meta_description) }}" />
<meta property="og:image" content="{{asset('assets/images/blogs'.$blog->photo)}}" />
<meta name="keywords" content="{{ $blog->meta_tag }}">
<meta name="description" content="{{ $blog->meta_description }}">
@endsection
@endif

@section('content')
<div class="main-breadcrumb-area"  style="background: url({{  asset('assets/images/genarel-settings/'.$gs->breadcumb_banner) }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="pagetitle">
                        {{__('Blog Details')}}
                    </h1>
                    <ul class="pages">
                        <li>
                            <a href="{{route('front.index')}}">
                                {{__('Home')}}
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{route('front.blog.show',$blog->slug)}}">
                                {{__('Blog Details')}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<section class="blog blog-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-box blog-details-box">
                    <div class="blog-images">
                            <div class="img">
                            <img src="{{asset('assets/images/blogs/'.$blog->image->image)}}" class="img-fluid" alt="blog-image">
                            </div>
                            <div class="blog-date d-flex justify-content-center">
                                <div class="box align-self-center">
                                    <p>{{ $blog->created_at->format('d')}}</p>
                                    <p>{{ $blog->created_at->format('M')}}</p>
                                </div>
                            </div>
                    </div>
                    <div class="details">
                            <a href='{{route('front.blog.show',$blog->slug)}}'>
                                <h4 class="blog-title">
                                    {{$blog->title}}
                                </h4>
                            </a>
                            <ul class="post-meta">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fas fa-user"></i>
                                        {{__('Admin')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fas fa-eye"></i>
                                        {{$blog->views}} {{__('views')}}
                                    </a>
                                </li>
                                @if($blog->source)
                                <li>
                                    <a href="javascript:;">
                                        <i class="fas fa-link"></i>
                                        {{$blog->source}} 
                                    </a>
                                </li>
                                @endif
                            </ul>
                        <div class="content">
                            <p class="blog-text">
                                {{strip_tags($blog->description)}}
                            </p>
                            <div id="disqus_thread"></div>
                        </div>
                    </div>
                    <div class="social-link  a2a_kit a2a_kit_size_32">
                        <ul class="social-links social-share">
                            <ul>
                            <li>
                                <a class="facebook a2a_button_facebook" href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                </li>
                                <li>
                                    <a class="twitter a2a_button_twitter" href="">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="linkedin a2a_button_linkedin" href="">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="pinterest a2a_button_pinterest" href="">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </li>
                                <li>
    
                                <a class="a2a_dd plus" href="https://www.addtoany.com/share">
                                    <i class="fas fa-plus"></i>
                                    </a>
                                </li>
                        </ul>
                    </div>
                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                </div>
                
            </div>
            <div class="col-lg-4">
                <div class="blog-aside">
                    <div class="serch-widget">
                        <h4 class="title">
                            {{__('Search')}}
                        </h4>
                        <form action="#">
                            <input type="text" placeholder="Search Content">
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

@endsection

@section('script')
@if ($gs->is_disqus == 1)
    <script>
        (function () { // DON'T EDIT BELOW THIS LINE
            var d = document,
            s = d.createElement('script');
            s.src = 'https://{{ $gs->disqus}}.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@endif


@endsection