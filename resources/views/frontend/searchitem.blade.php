@extends('frontend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/algolia.css') }}">
@endpush

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>Search Result for {{$menuitem->title}}</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <a href="{{route('shop', [$branch->id, $branch->branchlocation])}}">Shop</a>
                        <span>Search</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="shop__option">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="shop__option__search">
                            {{-- <form action="#"> --}}
                                {{-- <select>
                                    <option value="">Categories</option>
                                    <option value="">Red Velvet</option>
                                    <option value="">Cup Cake</option>
                                    <option value="">Biscuit</option>
                                </select> --}}
                                <div class="aa-input-container" id="aa-input-container">
                                    <input type="search" id="aa-search-input-algolia" class="aa-input-search" placeholder="Search" name="search"
                                        autocomplete="off" />
                                    <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                        <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                                    </svg>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                    {{-- <div class="col-lg-5 col-md-5">
                        <div class="shop__option__right">
                            <select>
                                <option value="">Default sorting</option>
                                <option value="">A to Z</option>
                                <option value="">1 - 8</option>
                                <option value="">Name</option>
                            </select>
                            <a href="#"><i class="fa fa-list"></i></a>
                            <a href="#"><i class="fa fa-reorder"></i></a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="row">
                @if (count($branchmenu) == 0)
                    Item is not available in any branch yet.
                @endif
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
                                <h5>{{$branchmenuitem->branch->branchlocation}}</h5>
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


            </div>
            <div class="shop__last__option">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="shop__pagination">
                            {{-- <a href="#">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#"><span class="arrow_carrot-right"></span></a> --}}
                            {{ $branchmenu->links() }}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        {{-- <div class="shop__last__text">
                            <p>Showing 1-9 of 10 results</p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection
@push('scripts')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
     <script src="{{ asset('frontend/js/algolia.js') }}"></script>
@endpush
