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
                        <h2>CookBook for {{$reqcategory->name}}</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>CookBook</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Class Section Begin -->
    <section class="class-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if (count($cookbookitems) == 0)
                            <p>No Items Available</p>
                        @endif
                        @foreach ($cookbookitems as $cookbookitem)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="class__item">
                                    <div class="class__item__pic set-bg" onclick="location.href='{{route('getrecipedetail', [$cookbookitem->id, $cookbookitem->slug])}}'" data-setbg="{{Storage::disk('uploads')->url($cookbookitem->itemimage)}}" style="cursor: pointer">
                                        @foreach ($cookbookitem->category as $reqcat)
                                            @php
                                                $cat = DB::table('cookbook_categories')->where('id', $reqcat)->first();
                                            @endphp
                                            <div class="label">{{$cat->name}}</div>
                                        @endforeach

                                    </div>
                                    <div class="class__item__text">
                                        <h5><a href="{{route('getrecipedetail', [$cookbookitem->id, $cookbookitem->slug])}}">{{$cookbookitem->itemname}}</a></h5>
                                        <span>{{date('d F, Y', strtotime($cookbookitem->created_at))}}</span>
                                        <p>{!! $cookbookitem->description !!}</p>
                                        <a href="{{route('getrecipedetail', [$cookbookitem->id, $cookbookitem->slug])}}" class="read_more">Read more</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="shop__pagination">
                        {{-- <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><span class="arrow_carrot-right"></span></a> --}}
                        {{ $cookbookitems->links() }}
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
                                @foreach ($popularitems as $pitem)
                                    <a href="{{route('getrecipedetail', [$pitem->id, $pitem->slug])}}" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{Storage::disk('uploads')->url($pitem->itemimage)}}" alt="" style="max-width: 100px;">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h4>{{$pitem->itemname}}</h4>
                                            <span>{{date('d F, Y', strtotime($pitem->created_at))}}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h5>Latest Categories</h5>
                            <div class="blog__sidebar__item__categories">
                                <ul>
                                    @foreach ($cookbookcategories as $cookbookcategory)
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($allcookbookitems as $allcookbookitem)
                                            @php
                                                $itemcategories = $allcookbookitem->category;
                                                if(in_array($cookbookcategory->id, $itemcategories))
                                                {
                                                    $count = $count + 1;
                                                }
                                            @endphp
                                        @endforeach

                                        <li><a href="{{route('categorycookbookrecipe', [$cookbookcategory->id, $cookbookcategory->slug])}}">{{$cookbookcategory->name}} <span>{{$count}}</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h5>Latest posts</h5>

                            <div class="blog__sidebar__recent">
                                @foreach ($latestitems as $litem)
                                    <a href="{{route('getrecipedetail', [$litem->id, $litem->slug])}}" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{Storage::disk('uploads')->url($litem->itemimage)}}" alt="" style="max-width: 100px;">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h4>{{$litem->itemname}}</h4>
                                            <span>{{date('d F, Y', strtotime($litem->created_at))}}</span>
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
    <!-- Class Section End -->

@endsection
@push('scripts')

@endpush
