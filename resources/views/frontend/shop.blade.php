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
                        <h2>Menu for location {{$selectedbranch->branchlocation}}</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>Menu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog__sidebar">

                        <div class="blog__sidebar__item">
                            <h5>Menu</h5>
                            <div class="blog__sidebar__item__categories">
                                <ul>
                                    @foreach ($categories as $category)
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($branchmenu as $item)
                                            @php
                                                $itemcategories = $item->menuitem->category_id;
                                                if(in_array($category->id, $itemcategories))
                                                {
                                                    $count = $count + 1;
                                                }
                                            @endphp
                                        @endforeach

                                        <li><a href="#{{$category->title}}" >{{$category->title}} <span>{{$count}}</span></a></li>
                                    @endforeach
                                    {{-- <li><a href="#momo" >Momo <span>36</span></a></li>
                                    <li><a href="#pizza">Pizza <span>18</span></a></li>
                                    <li><a href="#chowmein">Chowmein <span>09</span></a></li>
                                    <li><a href="#soup">Soup <span>12</span></a></li>
                                    <li><a href="#burger">Burger <span>27</span></a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h5>Popular Recipes</h5>
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
                            <h5>Follow us</h5>
                            <div class="blog__sidebar__social">
                                <a href="{{$setting->facebook}}"><i class="fa fa-facebook"></i></a>
                                <a href="{{$setting->linkedin}}"><i class="fa fa-linkedin"></i></a>
                                <a href="{{$setting->youtube}}"><i class="fa fa-youtube-play"></i></a>
                                <a href="{{$setting->instagram}}"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>


                    </div>
                </div>


           <div class="col-lg-8 pt-md-4 pt-sm-4 pt-xs-4 pt-lg-0" >
            <div class="shop__option">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <div class="shop__option__search">
                            {{-- <form action="#"> --}}
                                <!-- <select>
                                    <option value="">Categories</option>
                                    <option value="">Red Velvet</option>
                                    <option value="">Cup Cake</option>
                                    <option value="">Biscuit</option>
                                </select> -->
                                {{-- <input type="text" placeholder="Search">
                                <button type="submit"><i class="fa fa-search"></i></button> --}}
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
                    <div class="col-lg-5 col-md-5">
                        <div class="shop__option__right">
                            <form action="{{route('changebranch')}}" method="GET">
                                @csrf
                                <select name="changebranch" id="changebranch">
                                    @foreach ($branches as $currentbranch)
                                        <option value="{{$currentbranch->id}}" {{$currentbranch->id == $selectedbranch->id ? 'selected' : ''}}>{{$currentbranch->branchlocation}}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($branchmenu) > 0)
                <div class="col-lg-12" style="overflow: auto; max-height: 90vh;" >
                    @foreach ($categories as $category)
                        <div class="menu-section" id="{{$category->title}}">
                            <div class="section-title">
                                <h2>{{$category->title}}</h2>
                            </div>
                            <div class="row">
                                @php
                                    $categoryitems = array();
                                @endphp
                                @foreach ($branchmenu as $item)
                                    @php

                                        if(in_array($category->id, $item->menuitem->category_id))
                                        {
                                            array_push($categoryitems, $item->id);
                                        }
                                    @endphp
                                @endforeach

                                @if (count($categoryitems) > 0)
                                    @foreach ($categoryitems as $item)
                                        @php
                                            $branchmenuitem = DB::table('branch_menus')->where('id', $item)->first();
                                            $categoryitem = DB::table('menuitems')->where('id', $branchmenuitem->menuitem_id)->first();
                                            $itemimage = DB::table('menuitem_images')->where('menuitem_id', $categoryitem->id)->first();
                                        @endphp
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="food__item">
                                                <div class="food__item__pic set-bg" data-setbg="{{Storage::disk('uploads')->url($itemimage->filename)}}">
                                                    @if ($categoryitem->discount != 0)
                                                        <div class="food__label">
                                                            <span>{{$categoryitem->discount}}% Discount</span>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="food__item__text">
                                                    <h6><a href="{{route('shopdetails', [$branchmenuitem->id, $categoryitem->slug])}}">{{$categoryitem->title}}</a></h6>
                                                    <h6>({{$categoryitem->quantity}} {{$categoryitem->unit}})</h6>
                                                    @if ($categoryitem->discount != 0)
                                                        @php
                                                            $discountamount = ($categoryitem->discount / 100) * $categoryitem->price;
                                                            $afterdiscount = $categoryitem->price - $discountamount;
                                                        @endphp
                                                        <div class="product__item__price">Rs. {{ ceil($afterdiscount) }} <span>Rs.
                                                            {{ $categoryitem->price }}</span>
                                                        </div>
                                                    @else
                                                        <div class="food__item__price">Rs.{{$categoryitem->price}}</div>
                                                    @endif
                                                    @if (Auth::guest())
                                                        <div class="food__details__option">
                                                            <div class="quantity">
                                                                <div class="pro-qty">
                                                                    <input type="text" value="1">
                                                                </div>
                                                            </div>
                                                            <div class="cart_add">
                                                                <a href="javascript:void(0)" onclick="openLoginModal();">Add to cart</a>
                                                            </div>

                                                        </div>
                                                    @else
                                                        <form action="{{route('addtocart', $branchmenuitem->id)}}" id="formsubmit{{$branchmenuitem->id}}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <div class="food__details__option">
                                                                <div class="quantity">
                                                                    <div class="pro-qty">
                                                                        <input type="text" value="1" name="quantity" min="1">
                                                                    </div>
                                                                </div>
                                                                @if ($categoryitem->discount > 0)
                                                                    @php
                                                                        $discountamount = ($categoryitem->discount / 100) * $categoryitem->price;
                                                                        $afterdiscount = $categoryitem->price - $discountamount;
                                                                    @endphp

                                                                    <input type="hidden" value="{{ceil($afterdiscount)}}" name="price" class="form-control">
                                                                @else
                                                                    <input type="hidden" value="{{$categoryitem->price}}" name="price" class="form-control">
                                                                @endif
                                                                <div class="cart_add">
                                                                    <a href="#" onclick="document.getElementById('formsubmit{{$branchmenuitem->id}}').submit();">Add to cart</a>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                @else
                                No item in this category
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                No menu available for selected branch
            @endif

          </div>
        </div></div>



        </div>
    </section>
    <!-- Shop Section End -->

@endsection
@push('scripts')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
 <script src="{{ asset('frontend/js/algolia.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#changebranch').on('change', function() {
                this.form.submit();
            });
        });
  </script>
@endpush
