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
                        <h2>Shopping cart</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        @if (count($cartitems) == 0)
                            No Items In Cart
                        @else
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Branch</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                        @foreach ($cartitems as $item)
                                            @php
                                                $branchmenu = DB::table('branch_menus')->where('id', $item->branchmenu_id)->first();
                                                $branchinfo = DB::table('branches')->where('id', $branchmenu->branch_id)->first();
                                                $menuitem = DB::table('menuitems')->where('id', $branchmenu->menuitem_id)->first();
                                                $menuitemimage = DB::table('menuitem_images')->where('menuitem_id', $menuitem->id)->first();

                                            @endphp
                                            <tr>
                                                <td class="product__cart__item">
                                                    <div class="product__cart__item__pic">
                                                        <img src="{{Storage::disk('uploads')->url($menuitemimage->filename)}}" alt="" style="max-width: 100px">
                                                    </div>
                                                    <div class="product__cart__item__text">
                                                        <h6>{{$menuitem->title}}</h6>
                                                        <h5>({{$menuitem->quantity}} {{$menuitem->unit}})</h5>

                                                    </div>
                                                </td>
                                                <td class="cart__price">
                                                    {{$branchinfo->branchlocation}}
                                                </td>
                                                <td class="quantity__item">
                                                    <form action="{{route('updatequantity', $item->id)}}" id="formsubmit{{$item->id}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="quantity">
                                                            <div class="pro-qty">
                                                                <input type="text" value="{{$item->quantity}}" name="quantity" min="1">
                                                            </div>
                                                            <a href="#" onclick="document.getElementById('formsubmit{{$item->id}}').submit();" class="primary-btn site-btn mb-1 mt-3">Update</a>
                                                        </div>
                                                    </form>

                                                </td>
                                                <td class="cart__price">Rs. {{$item->price * $item->quantity}}</td>
                                                <td class="cart__close"><a href="{{route('removefromcart', $item->id)}}"><span class="icon_close"></span></a></td>
                                            </tr>
                                        @endforeach



                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn p-3">
                                <a href="{{route('shop',[$branch->id, $branch->branchlocation])}}">Continue Shopping</a>
                            </div>
                        </div>
                        {{-- <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    {{-- <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div> --}}
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            @if (count($cartitems) == 0)
                                <li>Subtotal <span>Rs. 0</span></li>
                                <li>Total <span>Rs. 0</span></li>
                            @else
                                @php
                                    $grandtotal = 0;
                                    foreach($cartitems as $cartitem)
                                    {
                                        $grandtotal = $grandtotal + ($cartitem->price * $cartitem->quantity);
                                    }
                                @endphp
                                <li>Subtotal <span>Rs. {{$grandtotal}}</span></li>
                                <li>Total <span>Rs. {{$grandtotal}}</span></li>
                                <li class="text-danger mt-3">Note*: Delivery charge will be applied according to distance.</li>
                            @endif

                        </ul>
                        <a href="{{route('checkout', Auth::user()->id)}}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->


@endsection
@push('scripts')

@endpush
