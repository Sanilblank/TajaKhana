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
                        <h2>MenuItem detail</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <a href="{{route('shop', [$selectedbranch->id, $selectedbranch->branchlocation])}}">Shop</a>
                        <span>{{$selecteditem->title}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__img">
                        <div class="product__details__big__img">
                            <img class="big_img" src="{{Storage::disk('uploads')->url($itemimage->filename)}}" alt="">
                        </div>
                        <div class="product__details__thumb">
                            @foreach ($itemimages as $item)
                                <div class="pt__item active">
                                    <img data-imgbigurl="{{Storage::disk('uploads')->url($item->filename)}}"
                                    src="{{Storage::disk('uploads')->url($item->filename)}}" alt="">
                                </div>
                            @endforeach

                            {{-- <div class="pt__item">
                                <img data-imgbigurl="{{asset('frontend/img/shop/details/product-big-1.jpg')}}"
                                src="{{asset('frontend/img/shop/details/product-big-1.jpg')}}" alt="">
                            </div>
                            <div class="pt__item">
                                <img data-imgbigurl="{{asset('frontend/img/shop/details/product-big-4.jpg')}}"
                                src="{{asset('frontend/img/shop/details/product-big-4.jpg')}}" alt="">
                            </div>
                            <div class="pt__item">
                                <img data-imgbigurl="{{asset('frontend/img/shop/details/product-big-3.jpg')}}"
                                src="{{asset('frontend/img/shop/details/product-big-3.jpg')}}" alt="">
                            </div>
                            <div class="pt__item">
                                <img data-imgbigurl="{{asset('frontend/img/shop/details/product-big-5.jpg')}}"
                                src="{{asset('frontend/img/shop/details/product-big-5.jpg')}}" alt="">
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        @foreach ($selecteditem->category_id as $item)
                            @php
                                $category = DB::table('categories')->where('id', $item)->first();
                            @endphp
                            <div class="product__label">{{$category->title}}</div>
                        @endforeach

                        <h4>{{$selecteditem->title}}</h4>
                        @if ($selecteditem->discount != 0)
                            @php
                                $discountamount = ($selecteditem->discount / 100) * $selecteditem->price;
                                $afterdiscount = $selecteditem->price - $discountamount;
                            @endphp
                            <div class="product__item__price h5">Rs. {{ ceil($afterdiscount) }} <span>Rs.
                                {{ $selecteditem->price }}</span>
                            </div>
                        @else
                            <div class="food__item__price h5">Rs.{{$selecteditem->price}}</div>
                        @endif

                        {{-- <p>{!! $selecteditem->details !!}</p> --}}
                        <ul>
                            <li>Amount: <span>{{$selecteditem->quantity}} {{$selecteditem->unit}}</span></li>
                            <li>Branch Location: <span>{{$selectedbranch->branchlocation}}</span></li>

                        </ul>
                        @if (Auth::guest())
                            <div class="product__details__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                                <a href="javascript:void(0)" onclick="openLoginModal();" class="primary-btn">Add to cart</a>
                                {{-- <a href="#" class="heart__btn"><span class="icon_heart_alt"></span></a> --}}
                            </div>
                        @else
                            <form action="{{route('addtocart', $branchmenuitem->id)}}" id="formsubmit{{$branchmenuitem->id}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="product__details__option">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1" name="quantity" min="1">
                                        </div>
                                    </div>
                                    @if ($selecteditem->discount > 0)
                                        @php
                                            $discountamount = ($selecteditem->discount / 100) * $selecteditem->price;
                                            $afterdiscount = $selecteditem->price - $discountamount;
                                        @endphp

                                        <input type="hidden" value="{{ceil($afterdiscount)}}" name="price" class="form-control">
                                    @else
                                        <input type="hidden" value="{{$selecteditem->price}}" name="price" class="form-control">
                                    @endif
                                    <div class="cart_add">
                                        <a href="#" class="primary-btn" onclick="document.getElementById('formsubmit{{$branchmenuitem->id}}').submit();">Add to cart</a>
                                    </div>

                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
            <div class="product__details__tab">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Item Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Chef Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">
                                    <p>{!! $selecteditem->details !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">
                                    @if (!$chefresponsible)
                                        <p>
                                           Responsibility of item has not been assigned yet.
                                        </p>
                                    @else
                                        <div class="row p-3">
                                            <div class="col-md-6">
                                                <p>Chef Name: {{$chefresponsible->chef->name}} <br> Chef Name: {{$chefresponsible->chef->contact}}</p>
                                                <div class="team__item__social text-center">
                                                    <a href="{{$chefresponsible->chef->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a>
                                                    <a href="{{$chefresponsible->chef->linkedin}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                                                    <a href="{{$chefresponsible->chef->instagram}}" target="_blank"><i class="fa fa-instagram"></i></a>
                                                    <a href="{{$chefresponsible->chef->youtube}}" target="_blank"><i class="fa fa-youtube-play"></i></a>
                                                </div>

                                            </div>

                                            <div class="col-md-6 text-center">
                                                <img src="{{Storage::disk('uploads')->url($chefresponsible->chef->photo)}}" style="max-width:100px">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>{!! $chefresponsible->chef->details !!}</p>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">
                                    <p>This delectable Strawberry Pie is an extraordinary treat filled with sweet and
                                        tasty chunks of delicious strawberries. Made with the freshest ingredients, one
                                        bite will send you to summertime. Each gift arrives in an elegant gift box and
                                        arrives with a greeting card of your choice that you can personalize online!3
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Products Section Begin -->
    <section class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <h2>Related Items</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="related__products__slider owl-carousel">
                    @foreach ($relateditems as $relateditem)
                        @php
                           $menuitem = DB::table('menuitems')->where('id', $relateditem->menuitem_id)->first();
                           $itemimage = DB::table('menuitem_images')->where('menuitem_id', $menuitem->id)->first();
                           $menuitemcategories = $relateditem->menuitem->category_id;
                        @endphp
                        <div class="col-lg-3">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{Storage::disk('uploads')->url($itemimage->filename)}}">
                                    <div class="product__label">
                                        @foreach ($menuitemcategories as $categoryid)
                                            @php
                                                $reqcategory = DB::table('categories')->where('id', $categoryid)->first();
                                            @endphp

                                            <span>{{$reqcategory->title}}</span>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{route('shopdetails', [$relateditem->id, $menuitem->title])}}">{{$menuitem->title}}</a></h6>
                                    <h6>({{$menuitem->quantity}} {{$menuitem->unit}})</h6>
                                    @if ($menuitem->discount != 0)
                                        @php
                                            $discountamount = ($menuitem->discount / 100) * $menuitem->price;
                                            $afterdiscount = $menuitem->price - $discountamount;
                                        @endphp
                                        <div class="product__item__price">Rs. {{ ceil($afterdiscount) }} <span>Rs.
                                            {{ $menuitem->price }}</span>
                                        </div>
                                    @else
                                        <div class="product__item__price">Rs.{{$menuitem->price}}</div>
                                    @endif
                                    <div class="cart_add">
                                        <form action="{{route('addtocart', $relateditem->id)}}" id="submit{{$relateditem->id}}" method="POST">
                                            @csrf
                                            @method('POST')
                                            @if ($menuitem->discount > 0)
                                                @php
                                                    $discountamount = ($menuitem->discount / 100) * $menuitem->price;
                                                    $afterdiscount = $menuitem->price - $discountamount;
                                                @endphp

                                                <input type="hidden" value="{{ceil($afterdiscount)}}" name="price" class="form-control">
                                            @else
                                                <input type="hidden" value="{{$menuitem->price}}" name="price" class="form-control">
                                            @endif
                                            <input type="hidden" value="1" name="quantity" class="form-control">

                                            <a href="#" onclick="document.getElementById('submit{{$relateditem->id}}').submit();">Add to cart</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!-- Related Products Section End -->

@endsection
@push('scripts')

@endpush
