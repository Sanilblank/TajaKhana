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
    <div class="blog-hero set-bg" data-setbg="{{Storage::disk('uploads')->url($cookbookitem->itemimage)}}">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-7">
                    <div class="blog__hero__text">
                        @foreach ($cookbookitem->category as $reqcat)
                            @php
                                $cat = DB::table('cookbook_categories')->where('id', $reqcat)->first();
                            @endphp
                            <div class="label">{{$cat->name}}</div>
                        @endforeach
                        <h2>{{$cookbookitem->itemname}}</h2>
                        <ul>
                            <li>By <span>{{$cookbookitem->recipeby}}</span></li>
                            <li>{{date('d F, Y', strtotime($cookbookitem->created_at))}}</li>
                            <li>{{$cookbookitem->view_count}} Views</li>
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
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <div class="blog__details__text">
                            <p>{!! $cookbookitem->description !!}</p>
                        </div>
                        <div class="blog__details__recipe">
                            <div class="blog__details__recipe__item">
                                <h6><img src="{{asset('frontend/img/blog/details/user.png')}}" alt=""> SERVES</h6>
                                <span>{{$cookbookitem->serving}} no of servings</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6><img src="{{asset('frontend/img/blog/details/clock.png')}}" alt=""> PREP TIME</h6>
                                <span>{{$cookbookitem->timetoprepare}}</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6><img src="{{asset('frontend/img/blog/details/clock.png')}}" alt=""> COOK TIME</h6>
                                <span>{{$cookbookitem->timetocook}}</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6> COURSE</h6>
                                <span>{{$cookbookitem->course}} no of servings</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6> CUISINE</h6>
                                <span>{{$cookbookitem->cuisine}}</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6> TIME OF DAY</h6>
                                <span>{{$cookbookitem->timeofday}}</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6> LEVEL OF COOKING</h6>
                                <span>{{$cookbookitem->levelofcooking->level}}</span>
                            </div>
                            <div class="blog__details__recipe__item">
                                <h6> RECIPE TYPE</h6>
                                <span>{{$cookbookitem->recipetype->type}}</span>
                            </div>
                        </div>
                        <div class="blog__details__recipe__details">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="blog__details__ingredients">
                                        <h6>Ingredients</h6>
                                        <p>{!! $cookbookitem->ingredients !!}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="blog__details__direction">
                            <h6>Steps</h6>
                            <p>{!! $cookbookitem->steps !!}</p>
                        </div>

                        <div class="blog__details__tags">
                            <span>Tag</span>
                            @foreach ($cookbookitem->category as $item)
                                @php
                                    $reqcat = DB::table('cookbook_categories')->where('id', $item)->first();
                                @endphp
                                <a href="{{route('categorycookbookrecipe', [$reqcat->id, $reqcat->slug])}}">{{$reqcat->name}}</a>
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
                                <img src="{{Storage::disk('uploads')->url($cookbookitem->recipebyimage)}}" alt="">
                            </div>
                            <div class="blog__details__author__text">
                                <h5>The Recipe is given by:</h5><br>
                                <h6>{{$cookbookitem->recipeby}}</h6>
                                <a href="{{route('authorrecipe', $cookbookitem->recipeby)}}">Click to View more from this author</a>
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
    <!-- Blog Details Section End -->

@endsection
@push('scripts')

@endpush
