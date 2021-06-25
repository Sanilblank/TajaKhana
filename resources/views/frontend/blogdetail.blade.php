@extends('frontend.layouts.app')
@push('styles')
<style>
    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
        color: seagreen;
    }
</style>
@endpush

@section('content')

    <!-- Blog Hero Begin -->
    <div class="blog-hero set-bg" data-setbg="{{Storage::disk('uploads')->url($blog->image)}}">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-7">
                    <div class="blog__hero__text">
                        @foreach ($blog->category as $reqcat)
                            @php
                                $cat = DB::table('blog_categories')->where('id', $reqcat)->first();
                            @endphp
                            <div class="label">{{$cat->name}}</div>
                        @endforeach
                        <h2>{{$blog->title}}</h2>
                        <ul>
                            <li>By <span>{{$blog->authorname}}</span></li>
                            <li>{{date('d F, Y', strtotime($blog->created_at))}}</li>
                            <li>{{$blog->view_count}} Views</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row d-flex">
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        {{-- <div class="blog__details__share">
                            <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="youtube"><i class="fa fa-youtube-play"></i></a>
                            <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                        </div> --}}
                        <div class="blog__details__text">
                            <p>{!! $blog->details !!}</p>
                        </div>
                        {{-- <div class="blog__details__recipe">
                            <div class="blog__details__recipe__item">
                                <h6><img src="{{asset('frontend/img/blog/details/user.png')}}" alt=""> SERVES</h6>
                                <span>2 as a main, 4 as a side</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6><img src="{{asset('frontend/img/blog/details/clock.png')}}" alt=""> PREP TIME</h6>
                                <span>15 minute</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6><img src="{{asset('frontend/img/blog/details/clock.png')}}" alt=""> COOK TIME</h6>
                                <span>15 minute</span>
                            </div>
                        </div> --}}

                        <div class="blog__details__tags">
                            <span>Tags</span>
                            @foreach ($blog->category as $item)
                                @php
                                    $reqcat = DB::table('blog_categories')->where('id', $item)->first();
                                @endphp
                                <a href="{{route('categoryblog', [$reqcat->id, $reqcat->slug])}}">{{$reqcat->name}}</a>
                            @endforeach
                        </div>
                        {{-- <div class="blog__details__btns">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__details__btns__item">
                                        <a href="#"><span class="arrow_carrot-left"></span> Previous posts</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__details__btns__item blog__details__btns__item--next">
                                        <a href="#">Next posts <span class="arrow_carrot-right"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="blog__details__author">
                            <div class="blog__details__author__pic">
                                <img src="{{Storage::disk('uploads')->url($blog->authorimage)}}" alt="">
                            </div>
                            <div class="blog__details__author__text">
                                <h5>The Post is written by:</h5><br>
                                <h6>{{$blog->authorname}}</h6>
                                <a href="{{route('authorblog', $blog->authorname)}}">Click to View more from this author</a>
                                {{-- <div class="blog__details__author__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                                </div> --}}
                                {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.</p> --}}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Enter keyword">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        {{-- <div class="blog__sidebar__item">
                            <h5>Follow me</h5>
                            <div class="blog__sidebar__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div> --}}
                        <div class="blog__sidebar__item">
                            <h5>Popular posts</h5>

                            <div class="blog__sidebar__recent">
                                @foreach ($popularblogs as $pblog)
                                    <a href="{{route('getblogdetail', $pblog->id)}}" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{Storage::disk('uploads')->url($pblog->image)}}" alt="" style="max-width: 100px;">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h4>{{$pblog->title}}</h4>
                                            <span>{{date('d F, Y', strtotime($pblog->created_at))}}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h5>Latest Categories</h5>
                            <div class="blog__sidebar__item__categories">
                                <ul>
                                    @foreach ($blogcategories as $blogcategory)
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($allblogs as $allblog)
                                            @php
                                                $itemcategories = $allblog->category;
                                                if(in_array($blogcategory->id, $itemcategories))
                                                {
                                                    $count = $count + 1;
                                                }
                                            @endphp
                                        @endforeach

                                        <li><a href="{{route('categoryblog', [$blogcategory->id, $blogcategory->slug])}}">{{$blogcategory->name}} <span>{{$count}}</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h5>Latest posts</h5>

                            <div class="blog__sidebar__recent">
                                @foreach ($latestblogs as $lblog)
                                    <a href="{{route('getblogdetail', $lblog->id)}}" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{Storage::disk('uploads')->url($lblog->image)}}" alt="" style="max-width: 100px;">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h4>{{$lblog->title}}</h4>
                                            <span>{{date('d F, Y', strtotime($lblog->created_at))}}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

@endsection
@push('scripts')

@endpush
