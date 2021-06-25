@extends('frontend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('frontend/StarRating/min/jquery.rateyo.min.css')}}"/>
@endpush

@section('content')

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>MenuItem detail<h2>
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

    {{-- Calculations for Review --}}
    @if ($chefresponsible)
        @php
            $reviews = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->orderBy('rating', 'DESC')->get();

            $noofreviews = count($reviews);
            $avgRatingFloat = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->avg('rating');
            $avgRating = number_format((float)$avgRatingFloat, 1, '.', '');
            $noof5stars = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->where('rating', 5)->count('rating');
            $noof4stars = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->where('rating', 4)->count('rating');
            $noof3stars = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->where('rating', 3)->count('rating');
            $noof2stars = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->where('rating', 2)->count('rating');
            $noof1stars = DB::table('reviews')->where('chef_id', $chefresponsible->chef_id)->where('disable', null)->where('rating', 1)->count('rating');
            if ($noofreviews == 0) {
                $per5stars = 0;
                $per4stars = 0;
                $per3stars = 0;
                $per2stars = 0;
                $per1stars = 0;
            }
            else {
                $percent5stars = ($noof5stars/$noofreviews) * 100 ;
                $percent4stars = ($noof4stars/$noofreviews) * 100 ;
                $percent3stars = ($noof3stars/$noofreviews) * 100 ;
                $percent2stars = ($noof2stars/$noofreviews) * 100 ;
                $percent1stars = ($noof1stars/$noofreviews) * 100 ;
                $per5stars = number_format((float)$percent5stars, 1, '.', '');
                $per4stars = number_format((float)$percent4stars, 1, '.', '');
                $per3stars = number_format((float)$percent3stars, 1, '.', '');
                $per2stars = number_format((float)$percent2stars, 1, '.', '');
                $per1stars = number_format((float)$percent1stars, 1, '.', '');
            }

        @endphp
    @else
            @php
                $avgRating = 0;
            @endphp
    @endif


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
                        <div class="row mb-3">
                            <div class="col-md-12">
                                @if ($selecteditem->is_combo == 1)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#requestChangeModal">
                                        Request Change
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="requestChangeModal" tabindex="-1" role="dialog" aria-labelledby="requestChangeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <p class="modal-title h6" id="requestChangeModalLabel">Request Change in Combo</p>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form action="{{route('reqcombomenu')}}" method="POST">
                                                @csrf
                                                @method('POST')

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="hidden" name="menuitem_id" value="{{$selecteditem->id}}">
                                                                <div class="form-group">
                                                                    <label for="fullname">Full Name: </label>
                                                                    <input type="text" name="fullname" class="form-control" value="{{ @old('fullname') }}"
                                                                        placeholder="Enter Your Name">
                                                                    @error('fullname')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="contactno">Contact Info: </label>
                                                                    <input type="text" name="contactno" class="form-control" value="{{ @old('contactno') }}"
                                                                        placeholder="Enter Contact No">
                                                                    @error('contactno')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="description">Description:</label>
                                                                    <textarea name="description" class="form-control" cols="30" rows="10"
                                                                        placeholder="Enter description of what you would like to change"></textarea>

                                                                    @error('description')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Request</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (Auth::guest())
                            <div class="product__details__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                                <a href="javascript:void(0)" onclick="openLoginModal();" class="primary-btn">Add to cart</a>
                                <a href="javascript:void(0)" onclick="openLoginModal();" class="heart__btn"><span class="icon_heart_alt"></span></a>
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
                                        <a href="{{route('addtowishlist', $branchmenuitem->id)}}" class="heart__btn"><span class="icon_heart_alt"></span></a>
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
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews for Chef</a>
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
                                    @if (!$chefresponsible)
                                        <p>Responsibility of item has not been assigned yet.</p>
                                    @else
                                        <div class="mod-rating mt-3">
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p style="font-size: 50px"><b>{{$avgRating}}</b><span style="font-size: 30px">/5</span></p>
                                                        <div class="rateyo-readonly-widg"></div>
                                                        <p>{{$noofreviews}} ratings</p>

                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                @for ($i = 5; $i > 0; $i--)
                                                                    <i class="fa fa-star" style="font-size: 15px; color: orange;"></i>
                                                                @endfor
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="progress" style="width: 300px; height: 15px; margin-top: 5px;">
                                                                    <div class="progress-bar bg-warning" style="width:{{$per5stars}}%"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{$noof5stars}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                @for ($i = 4; $i > 0; $i--)
                                                                    <i class="fa fa-star" style="font-size: 15px; color: orange;"></i>
                                                                @endfor
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="progress" style="width: 300px; height: 15px; margin-top: 5px;">
                                                                    <div class="progress-bar bg-warning" style="width:{{$per4stars}}%"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{$noof4stars}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                @for ($i = 3; $i > 0; $i--)
                                                                    <i class="fa fa-star" style="font-size: 15px; color: orange;"></i>
                                                                @endfor
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="progress" style="width: 300px; height: 15px; margin-top: 5px;">
                                                                    <div class="progress-bar bg-warning" style="width:{{$per3stars}}%"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{$noof3stars}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                @for ($i = 2; $i > 0; $i--)
                                                                    <i class="fa fa-star" style="font-size: 15px; color: orange;"></i>
                                                                @endfor
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="progress" style="width: 300px; height: 15px; margin-top: 5px;">
                                                                    <div class="progress-bar bg-warning" style="width:{{$per2stars}}%"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{$noof2stars}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                @for ($i = 1; $i > 0; $i--)
                                                                    <i class="fa fa-star" style="font-size: 15px; color: orange;"></i>
                                                                @endfor
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="progress" style="width: 300px; height: 15px; margin-top: 5px;">
                                                                    <div class="progress-bar bg-warning" style="width:{{$per1stars}}%"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                {{$noof1stars}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="customer-review-option mt-4">
                                            @if (Auth::guest())
                                                <a href="javascript:void(0)" onclick="openLoginModal();" class="btn btn-primary" style="background-color: #f39c12; border: none;">Login to leave or modify Review</a>
                                                <br><hr>
                                            @else
                                                @php
                                                    $userreview = DB::table('reviews')->where('user_id', Auth::user()->id)->where('chef_id', $chefresponsible->chef_id)->first();
                                                @endphp
                                                @if ($userreview)
                                                    <hr>
                                                    <h5 style="color: #b83955; margin-bottom:1rem;">Your Review
                                                        {{-- <a href="#" class="btn btn-success btn-sm ml-4">&nbsp; Edit &nbsp;</a> --}}
                                                        <button type="button" class="btn btn-success btn-sm ml-4" data-toggle="modal" data-target="#editreviewModal{{$chefresponsible->chef_id . Auth::user()->id}}">&nbsp; Edit &nbsp;</button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="editreviewModal{{$chefresponsible->chef_id . Auth::user()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <h5 class="modal-title" id="editreviewModalLabel">Update your Review</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>
                                                                <form action="{{route('updatereview', $userreview->id)}}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <div class="container d-flex justify-content-center">
                                                                                    <div class="row">
                                                                                        <div class="col-md-2">
                                                                                        </div>
                                                                                        <div class="col-md-9">
                                                                                            <div class="stars">
                                                                                                <input class="star star-5" id="starrating-5{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="5"

                                                                                                @if ($userreview->rating == 5)
                                                                                                    checked
                                                                                                @endif />
                                                                                                <label class="star star-5" for="starrating-5{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                                <input class="star star-4" id="starrating-4{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="4"

                                                                                                @if ($userreview->rating == 4)
                                                                                                    checked
                                                                                                @endif />
                                                                                                <label class="star star-4" for="starrating-4{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                                <input class="star star-3" id="starrating-3{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="3"

                                                                                                @if ($userreview->rating == 3)
                                                                                                    checked
                                                                                                @endif />
                                                                                                <label class="star star-3" for="starrating-3{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                                <input class="star star-2" id="starrating-2{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="2"

                                                                                                @if ($userreview->rating == 2)
                                                                                                    checked
                                                                                                @endif />
                                                                                                <label class="star star-2" for="starrating-2{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                                <input class="star star-1" id="starrating-1{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="1"

                                                                                                @if ($userreview->rating == 1)
                                                                                                    checked
                                                                                                @endif />
                                                                                                <label class="star star-1" for="starrating-1{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <textarea rows="4" cols="40" class="form-control" placeholder="Describe your experience (optional)" name="ratingdescription">{{$userreview->description}}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal Ends -->

                                                        <form action="{{route('deleteuserreview', $userreview->id)}}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                        </form>
                                                        </h5>


                                                    <div class="co-item">
                                                        <div class="avatar-text">
                                                                <h5 style="color: #3B5998">{{$userreview->username}} - <span style="font-size: 15px">{{ \Carbon\Carbon::parse($userreview->updated_at)->diffForHumans() }}</span></h5>
                                                                <div class="at-rating mb-2">
                                                                    @for ($i = $userreview->rating; $i > 0; $i--)
                                                                        <i class="fa fa-star" style="color: #ffc107"></i>
                                                                    @endfor
                                                                    @for ($i =5 - $userreview->rating; $i > 0; $i--)
                                                                        <i class="fa fa-star-o" style="color: grey"></i>
                                                                    @endfor
                                                                </div>
                                                                <div class="at-reply">{{$userreview->description}}</div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h5 style="color: #b83955">All Reviews</h5>
                                                    <br>
                                                @else
                                                    {{-- <a href="#" class="btn btn-primary" style="background-color: #f39c12; border: none;">Leave a Review</a> --}}
                                                    <button type="button" class="btn btn-primary" style="background-color: #f39c12; border: none;" data-toggle="modal" data-target="#reviewModal{{$chefresponsible->chef_id . Auth::user()->id}}">Leave a Review</button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="reviewModal{{$chefresponsible->chef_id . Auth::user()->id}}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="reviewModalLabel">Leave a Review</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <form action="{{route('addreview')}}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <div class="container d-flex justify-content-center">
                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                    </div>
                                                                                    <div class="col-md-9">
                                                                                        <div class="stars">
                                                                                            <input class="star star-5" id="star-5{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="5"/>
                                                                                            <label class="star star-5" for="star-5{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                            <input class="star star-4" id="star-4{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="4"/>
                                                                                            <label class="star star-4" for="star-4{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                            <input class="star star-3" id="star-3{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="3"/>
                                                                                            <label class="star star-3" for="star-3{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                            <input class="star star-2" id="star-2{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="2"/>
                                                                                            <label class="star star-2" for="star-2{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                            <input class="star star-1" id="star-1{{$chefresponsible->chef_id . Auth::user()->id}}" type="radio" name="star" value="1"/>
                                                                                            <label class="star star-1" for="star-1{{$chefresponsible->chef_id . Auth::user()->id}}"></label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <input type="hidden" name="username" value="{{Auth::user()->name}}">
                                                                                        <input type="hidden" name="chef_id" value="{{$chefresponsible->chef_id}}">
                                                                                        <textarea rows="4" cols="40" class="form-control" placeholder="Describe your experience (optional)" name="ratingdescription"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal Ends -->
                                                    <br><hr>
                                                @endif

                                            @endif
                                            @if ($noofreviews == 0)
                                                <p style="color: gray">No reviews for this chef</p>

                                            @else
                                                @if (count($reviews) == 0)
                                                        <p style="color: gray">No reviews given by others for this chef</p>
                                                @else
                                                    @foreach ($reviews as $review)
                                                            <div class="co-item">
                                                                <div class="avatar-text">
                                                                        <h5 style="color: #3B5998">{{$review->username}} - <span style="font-size: 15px">{{ \Carbon\Carbon::parse($review->updated_at)->diffForHumans() }}</span></h5>
                                                                        <div class="at-rating mb-2">
                                                                            @for ($i = $review->rating; $i > 0; $i--)
                                                                                <i class="fa fa-star" style="color: #ffc107"></i>
                                                                            @endfor
                                                                            @for ($i =5 - $review->rating; $i > 0; $i--)
                                                                                <i class="fa fa-star-o" style="color: grey"></i>
                                                                            @endfor
                                                                        </div>
                                                                        <div class="at-reply">{{$review->description}}</div>
                                                                </div>
                                                            </div>
                                                            <hr>

                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>


                                    @endif

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
                                    @if (Auth::guest())
                                        <div class="cart_add">
                                            <a href="javascript:void(0)" onclick="openLoginModal();">Add to cart</a>
                                        </div>
                                    @else
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
                                    @endif

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
<script type="text/javascript" src="{{asset('frontend/StarRating/src/jquery.rateyo.js')}}"></script>

<script>

  $(function () {

    var rating = {{$avgRating}};

    $(".rateyos-readonly-widg").rateYo({

      rating: rating,
      numStars: 5,
      precision: 2,
      starWidth: "20px",
      minValue: 1,
      maxValue: 5
    }).on("rateyo.change", function (e, data) {
      console.log(data.rating);
    });

    $(".rateyo-readonly-widg").rateYo({

        rating: rating,
        numStars: 5,
        precision: 2,
        starWidth: "32px",
        minValue: 1,
        maxValue: 5
        }).on("rateyo.change", function (e, data) {
        console.log(data.rating);
        });
  });
</script>
@endpush
