@extends('frontend.layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/blogalgolia.css') }}">

@endpush

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>Blogs by {{$name}}</h2>
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
                            {{-- <form action="#">
                                <input type="text" placeholder="Enter keyword">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form> --}}
                            <div class="aa-input-container" id="aa-input-container">
                                <input type="search" id="aa-search-input-algolia" class="aa-input-search" placeholder="Search" name="search"
                                    autocomplete="off" />
                                <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                    <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                                </svg>
                            </div>
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
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
 <script src="{{ asset('frontend/js/blogalgolia.js') }}"></script>
@endpush
