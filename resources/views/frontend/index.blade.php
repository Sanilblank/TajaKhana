@extends('frontend.layouts.app')
@push('styles')
<style>
    a {
        color: seagreen;
    }

    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
        color: seagreen;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            @foreach ($sliders as $slider)
            <div onclick="location.href='{{route('shop', [$branch->id, $branch->branchlocation])}}'" class="hero__item set-bg" data-setbg="{{Storage::disk('uploads')->url($slider->images)}}" style="cursor: pointer">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <div class="hero__text">
                                <h2>{{$slider->title}}</h2>
                                <p>{!! $slider->description !!}</p>
                                <a href="{{route('shop', [$branch->id, $branch->branchlocation])}}" class="primary-btn">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Locations Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Quick Service</span>
                            <h2>Tajakhana Locations</h2>
                        </div>
                        <p>Place orders from your nearest location for faster meals.
                                Choose the location suitable for you.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="about__bar">
                        <div class="locations_slider owl-carousel">

                            @foreach ($branches as $mainbranch)
                                <div class="cookbook">
                                    <div class="cookbook__pic set-bg" onclick="location.href='{{route('shop', [$mainbranch->id, $mainbranch->branchlocation])}}'" data-setbg="{{Storage::disk('uploads')->url($mainbranch->branchimage)}}" style="cursor: pointer">

                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="{{route('shop', [$mainbranch->id, $mainbranch->branchlocation])}}">{{$mainbranch->branchlocation}}</a></h5>

                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="{{route('shop', [$mainbranch->id, $mainbranch->branchlocation])}}" class="read_more">View Menu</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Locations Section End -->


    <!-- Cookbook Section Begin -->
    <section class="about ">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6 order-sm-12 order-xs-12 order-md-1 order-lg-1">
                    <div class="about__bar">
                        <div class="locations_slider owl-carousel">
                            @foreach ($cookbookitems as $cookbookitem)
                                <div class="cookbook">
                                    <div class="cookbook__pic set-bg" onclick="location.href='{{route('getrecipedetail', [$cookbookitem->id, $cookbookitem->slug])}}'" data-setbg="{{Storage::disk('uploads')->url($cookbookitem->itemimage)}}" style="cursor: pointer">
                                        @foreach ($cookbookitem->category as $reqcat)
                                            @php
                                                $cat = DB::table('cookbook_categories')->where('id', $reqcat)->first();
                                            @endphp
                                            <div class="label">{{$cat->name}}</div>
                                        @endforeach
                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="{{route('getrecipedetail', [$cookbookitem->id, $cookbookitem->slug])}}">{{$cookbookitem->itemname}}</a></h5>
                                        <span>{{date('d F, Y', strtotime($cookbookitem->created_at))}}</span>
                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="{{route('getrecipedetail', [$cookbookitem->id, $cookbookitem->slug])}}" class="read_more">Read more</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
                <div class="col-lg-5 col-md-6 order-sm-1 order-xs-1">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Best Recipes</span>
                            <h2>TajaCookbook</h2>
                        </div>
                        <p>Make your favourite meals from our personalised Cookbook.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cookbook Section End -->
    <!-- Blog Section Begin -->
    <section class="about spad " style="padding-bottom: 10px;">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-6 pb-4 text-center">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Best Food Bloggers</span>
                            <h2>Taja Blogs</h2>
                        </div>
                        <p>Get the tips & tricks you are looking for. We have awesome bloggers who will help in your food journeys
                        </p>
                    </div>
                </div>

                <div class="col-lg-12 col-md-6">
                    <div class="about__bar">
                        <div class="blogs_slider owl-carousel">
                            @foreach ($blogs as $blog)
                                <div class="class__item">
                                    <div class="class__item__pic set-bg" onclick="location.href='{{route('getblogdetail', $blog->id)}}'" data-setbg="{{Storage::disk('uploads')->url($blog->image)}}" style="cursor: pointer">
                                        @php
                                            $cat = DB::table('blog_categories')->where('id', $blog->category[0])->first();
                                        @endphp
                                        <div class="label">{{$cat->name}}</div>
                                    </div>
                                    <div class="class__item__text">
                                        <h5><a href="{{route('getblogdetail', $blog->id)}}">{{$blog->title}}</a></h5>
                                        <span>{{date('d F, Y', strtotime($blog->created_at))}}</span>
                                        {{-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> --}}
                                        <a href="{{route('getblogdetail', $blog->id)}}" class="read_more">Read more</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Locations Section End -->




    <!-- Categories Section Begin -->
    <div class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-6 pb-4 text-center pb-4">
                    <div class="about__text">
                        <div class="section-title">
                            <span>Special Menu</span>
                            <h2>TajaKhana Menu</h2>
                        </div>
                        <p>Eat well,Live well
                        </p>
                    </div>
                </div>
                {{-- <div class="categories__slider owl-carousel">
                    <div class="categories__item">
                        <div class="categories__item__icon">
                            <span class="flaticon-029-cupcake-3"></span>
                            <h5>Cupcake</h5>
                        </div>
                    </div>
                    <div class="categories__item">
                        <div class="categories__item__icon">
                            <span class="flaticon-034-chocolate-roll"></span>
                            <h5>Butter</h5>
                        </div>
                    </div>
                    <div class="categories__item">
                        <div class="categories__item__icon">
                            <span class="flaticon-005-pancake"></span>
                            <h5>Red Velvet</h5>
                        </div>
                    </div>
                    <div class="categories__item">
                        <div class="categories__item__icon">
                            <span class="flaticon-030-cupcake-2"></span>
                            <h5>Biscuit</h5>
                        </div>
                    </div>
                    <div class="categories__item">
                        <div class="categories__item__icon">
                            <span class="flaticon-006-macarons"></span>
                            <h5>Donut</h5>
                        </div>
                    </div>
                    <div class="categories__item">
                        <div class="categories__item__icon">
                            <span class="flaticon-006-macarons"></span>
                            <h5>Cupcake</h5>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">


                    @foreach ($branchmenu as $branchmenuitem)
                        @php
                            $itemimage = DB::table('menuitem_images')->where('menuitem_id', $branchmenuitem->menuitem_id)->first();
                        @endphp
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" onclick="location.href='{{route('shopdetails', [$branchmenuitem->id, $branchmenuitem->menuitem->slug])}}'" data-setbg="{{Storage::disk('uploads')->url($itemimage->filename)}}" style="cursor: pointer">
                                    <div class="product__label">
                                        @if ($branchmenuitem->menuitem->discount > 0)
                                            <span>{{$branchmenuitem->menuitem->discount}}% discount</span>

                                        @endif
                                    </div>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{route('shopdetails', [$branchmenuitem->id, $branchmenuitem->menuitem->slug])}}">{{$branchmenuitem->menuitem->title}}</a></h6>
                                    <h6>({{$branchmenuitem->menuitem->quantity}} {{$branchmenuitem->menuitem->unit}})</h6>
                                    @if ($branchmenuitem->menuitem->discount != 0)
                                        @php
                                            $discountamount = ($branchmenuitem->menuitem->discount / 100) * $branchmenuitem->menuitem->price;
                                            $afterdiscount = $branchmenuitem->menuitem->price - $discountamount;
                                        @endphp
                                        <div class="product__item__price">Rs. {{ ceil($afterdiscount) }} <span>Rs.
                                            {{ $branchmenuitem->menuitem->price }}</span>
                                        </div>
                                    @else
                                        <div class="product__item__price">Rs.{{$branchmenuitem->menuitem->price}}</div>
                                    @endif
                                    @if (Auth::guest())
                                        <div class="cart_add">
                                            <a href="javascript:void(0)" onclick="openLoginModal();">Add to cart</a>
                                        </div>
                                    @else
                                        <div class="cart_add">
                                            <form action="{{route('addtocart', $branchmenuitem->id)}}" id="submit{{$branchmenuitem->id}}" method="POST">
                                                @csrf
                                                @method('POST')
                                                @if ($branchmenuitem->menuitem->discount > 0)
                                                    @php
                                                        $discountamount = ($branchmenuitem->menuitem->discount / 100) * $branchmenuitem->menuitem->price;
                                                        $afterdiscount = $branchmenuitem->menuitem->price - $discountamount;
                                                    @endphp

                                                    <input type="hidden" value="{{ceil($afterdiscount)}}" name="price" class="form-control">
                                                @else
                                                    <input type="hidden" value="{{$branchmenuitem->menuitem->price}}" name="price" class="form-control">
                                                @endif
                                                <input type="hidden" value="1" name="quantity" class="form-control">

                                                <a href="#" onclick="document.getElementById('submit{{$branchmenuitem->id}}').submit();">Add to cart</a>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                <div class="col-lg-12 col-md-6 pb-4 text-center pb-4">
                    <div class="about__text">
                        <div class="section-title">
                            <span><u><a href="{{route('shop', [$selectedbranch->id, $selectedbranch->branchlocation])}}">View Full Menu</a></u></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Team Section Begin -->
    <section class="team spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7">
                    <div class="section-title">
                        <span>Our team</span>
                        <h2>Newest Members </h2>
                    </div>
                </div>
                {{-- <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="team__btn">
                        <a href="#" class="primary-btn">Join Us</a>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                @foreach ($chefs as $chef)
                    <div class="col-lg-3  col-md-6 col-sm-6">
                        <div class="team__item set-bg" data-setbg="{{Storage::disk('uploads')->url($chef->photo)}}">
                            <div class="team__item__text">
                                <h6>{{$chef->name}}</h6>
                                <span>{{$chef->branch->branchlocation}}</span>
                                <div class="team__item__social">
                                    <a href="{{$chef->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a href="{{$chef->linkedin}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                                    <a href="{{$chef->instagram}}" target="_blank"><i class="fa fa-instagram"></i></a>
                                    <a href="{{$chef->youtube}}" target="_blank"><i class="fa fa-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach




            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <span>Testimonial</span>
                        <h2>Our client say</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="testimonial__slider owl-carousel">
                    @foreach ($reviews as $review)
                        <div class="col-lg-6">
                            <div class="testimonial__item">
                                <div class="testimonial__author">
                                    <div class="testimonial__author__pic">
                                        <img src="{{Storage::disk('uploads')->url('user.png')}}" alt="">
                                    </div>
                                    <div class="testimonial__author__text">
                                        <h5>{{$review->username}}</h5>
                                        <span>{{$review->user->email}}</span>
                                    </div>
                                </div>
                                <div class="rating">
                                    @for ($i = $review->rating; $i > 0; $i--)
                                        <i class="fa fa-star" style="color: #ffc107"></i>
                                    @endfor
                                    @for ($i =5 - $review->rating; $i > 0; $i--)
                                        <i class="fa fa-star-o" style="color: grey"></i>
                                    @endfor
                                </div>
                                <p>{{$review->description}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

     <!-- Partner Logo Section Begin -->
     {{-- <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{asset('frontend/img/logo-carousel/logo-1.png')}}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{asset('frontend/img/logo-carousel/logo-2.png')}}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{asset('frontend/img/logo-carousel/logo-3.png')}}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{asset('frontend/img/logo-carousel/logo-4.png')}}" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="{{asset('frontend/img/logo-carousel/logo-5.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Partner Logo Section End -->

    <!-- Map Begin -->
    {{-- <div class="map">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-7">
                    <div class="map__inner">
                        <h6>COlorado</h6>
                        <ul>
                            <li>1000 Lakepoint Dr, Frisco, CO 80443, USA</li>
                            <li>Sweetcake@support.com</li>
                            <li>+1 800-786-1000</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="map__iframe">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d10784.188505644011!2d19.053119335158936!3d47.48899529453826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1543907528304" height="300" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div> --}}
    <!-- Map End -->

@endsection
@push('scripts')

@endpush




