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
                        <h2>Checkout</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="{{route('placeorder')}}" method="POST">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            {{-- <h6 class="coupon__code"><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click
                            here</a> to enter your code</h6> --}}
                            <h6 class="checkout__title">Billing Details</h6>
                            {{-- <form action="{{route('placeorder')}}" method="POST"> --}}
                                @csrf
                                @method('POST')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Fist Name<span>*</span></p>
                                                <input type="text" required name="firstname" class="form-control" placeholder="Your First Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Last Name<span>*</span></p>
                                                <input type="text" required name="lastname" class="form-control" placeholder="Your Last Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout__input">
                                        <p>Disctrict<span>*</span></p>
                                        <input type="text" required class="form-control" placeholder="District you live in" name="district">

                                    </div>
                                    <div class="checkout__input">
                                        <p>Address<span>*</span></p>
                                        <input type="text" required placeholder="Street Address / Tole (Ex: Swoyambhu-15)" class="form-control" name="address">


                                    </div>
                                    <div class="checkout__input">
                                        <p>Town/City<span>*</span></p>
                                        <input type="text" required placeholder="Ex: Kathmandu" name="town" class="form-control">

                                    </div>

                                    <div class="checkout__input">
                                        <p>Postcode / ZIP<span>*</span></p>
                                        <input type="text" required name="postcode" class="form-control" placeholder="Ex: 44600">

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Phone<span>*</span></p>
                                                <input type="text" required name="phone" class="form-control" placeholder="Your phone no.">

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Email<span>*</span></p>
                                                <input type="text" required name="email" class="form-control" placeholder="Your email address">

                                            </div>
                                        </div>
                                    </div>
                            {{-- </form> --}}
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h6 class="order__title">Your order</h6>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach ($cartitems as $item)
                                        @php
                                            $branchmenu = DB::table('branch_menus')->where('id', $item->branchmenu_id)->first();
                                            // $branchinfo = DB::table('branches')->where('id', $branchmenu->branch_id)->first();
                                            $menuitem = DB::table('menuitems')->where('id', $branchmenu->menuitem_id)->first();
                                        @endphp
                                        <li>{{$menuitem->title}} ({{$item->quantity}} * {{$item->price}})<span>Rs. {{$item->quantity * $item->price}}</span></li>
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    @php
                                        $grandtotal = 0;
                                        foreach($cartitems as $cartitem)
                                        {
                                            $grandtotal = $grandtotal + ($cartitem->price * $cartitem->quantity);
                                        }
                                    @endphp
                                    <li>Subtotal <span>Rs. {{$grandtotal}}</span></li>
                                    <li>Total <span>Rs. {{$grandtotal}}</span></li>
                                </ul>
                                <div class="checkout__input__checkbox">
                                    {{-- <label for="acc-or">
                                        Create an account?
                                        <input type="checkbox" id="acc-or">
                                        <span class="checkmark"></span>
                                    </label> --}}
                                </div>
                                <p class="text-danger">Note*:Delivery charge will be applied according to distance.</p>
                                {{-- <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Check Payment
                                        <input type="checkbox" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div> --}}
                                {{-- <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Paypal
                                        <input type="checkbox" id="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div> --}}
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

@endsection
@push('scripts')

@endpush
