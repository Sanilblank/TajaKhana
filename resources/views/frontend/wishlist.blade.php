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
                        <h2>Wishlist</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>Wishlist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Wishlist Section Begin -->
    <section class="wishlist spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if (count($wishlistproducts) == 0)
                        No items in wishlist.
                    @else
                        <div class="wishlist__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Branch</th>
                                        <th>Unit Price</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlistproducts as $item)
                                        @php
                                        $itemimage = DB::table('menuitem_images')->where('menuitem_id', $item->branchmenu->menuitem_id)->first();
                                        @endphp
                                        <tr>
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <img src="{{Storage::disk('uploads')->url($itemimage->filename)}}" alt="" style="max-width: 100px">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6>{{$item->branchmenu->menuitem->title}}</h6>
                                                    <h5>({{$item->branchmenu->menuitem->quantity}} {{$item->branchmenu->menuitem->unit}})</h5>
                                                </div>
                                            </td>
                                            <td class="cart__price">
                                                {{$item->branchmenu->branch->branchlocation}}
                                            </td>
                                            @if ($item->branchmenu->menuitem->discount != 0)
                                                @php
                                                    $discountamount = ($item->branchmenu->menuitem->discount / 100) * $item->branchmenu->menuitem->price;
                                                    $afterdiscount = $item->branchmenu->menuitem->price - $discountamount;
                                                @endphp
                                                <td class="product__item__price h5">Rs. {{ ceil($afterdiscount) }} <span>Rs.
                                                    {{ $item->branchmenu->menuitem->price }}</span>
                                                </td>
                                            @else
                                                <td class="food__item__price h5">Rs.{{$item->branchmenu->menuitem->price}}</td>
                                            @endif

                                                <form action="{{route('addtocart', $item->branchmenu_id)}}" id="submit{{$item->branchmenu_id}}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    @if ($item->branchmenu->menuitem->discount > 0)
                                                        @php
                                                            $discountamount = ($item->branchmenu->menuitem->discount / 100) * $item->branchmenu->menuitem->price;
                                                            $afterdiscount = $item->branchmenu->menuitem->price - $discountamount;
                                                        @endphp

                                                        <input type="hidden" value="{{ceil($afterdiscount)}}" name="price" class="form-control">
                                                    @else
                                                        <input type="hidden" value="{{$item->branchmenu->menuitem->price}}" name="price" class="form-control">
                                                    @endif
                                                    <input type="hidden" value="1" name="quantity" class="form-control">

                                                    <td class="cart__btn"><a href="#" class="primary-btn" onclick="document.getElementById('submit{{$item->branchmenu_id}}').submit();">Add to cart</a></td>
                                                </form>


                                            <td class="cart__close"><a href="{{route('removefromwishlist', $item->id)}}"><span class="icon_close"></span></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- Wishlist Section End -->

@endsection
@push('scripts')

@endpush
