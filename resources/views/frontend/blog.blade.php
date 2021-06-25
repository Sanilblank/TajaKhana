@extends('frontend.layouts.app')
@push('styles')

@endpush

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>TajaKhana Blogs</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if (count($blogs) == 0)
                        <p>No Items Available</p>
                    @endif
                    @foreach ($blogs as $blog)
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" onclick="location.href='{{route('getblogdetail', $blog->id)}}'" data-setbg="{{Storage::disk('uploads')->url($blog->image)}}" style="cursor: pointer">
                                <div class="blog__pic__inner">
                                    @foreach ($blog->category as $reqcat)
                                        @php
                                            $cat = DB::table('blog_categories')->where('id', $reqcat)->first();
                                        @endphp
                                        <div class="label">{{$cat->name}}</div>
                                    @endforeach
                                    <ul>
                                        <li>By <span>{{$blog->authorname}}</span></li>
                                        <li>{{date('d F, Y', strtotime($blog->created_at))}}</li>
                                        <li>{{$blog->view_count}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="blog__item__text">
                                <h2>{{$blog->title}}</h2>

                                <a href="{{route('getblogdetail', $blog->id)}}">READ MORE</a>
                            </div>
                        </div>
                    @endforeach


                    <div class="shop__pagination">
                        {{-- <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><span class="arrow_carrot-right"></span></a> --}}
                        {{ $blogs->links() }}
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
    <!-- Blog Section End -->

@endsection
@push('scripts')

@endpush
