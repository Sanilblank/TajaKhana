    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__cart">
            <div class="offcanvas__cart__links">
                <a href="#" class="search-switch"><img src="{{asset('frontend/img/icon/search.png')}}" alt=""></a>
                <a href="#"><img src="{{asset('frontend/img/icon/heart.png')}}" alt=""></a>
            </div>
            <div class="offcanvas__cart__item">
                <a href="{{route('cart')}}"><img src="{{asset('frontend/img/icon/cart.png')}}" alt=""> <span>0</span></a>
                <div class="cart__price">Cart: <span>$0.00</span></div>
            </div>
        </div>
        <div class="offcanvas__logo">
            <a href="{{route('index')}}"><img src="{{Storage::disk('uploads')->url($setting->headerImage)}}" alt="Header Logo"></a>
        </div>
        <div id="mobile-menu-wrap"></div> <!-- Mobile View Menu -->
        <div class="offcanvas__option">
            <ul>
                <li>USD <span class="arrow_carrot-down"></span>
                    <ul>
                        <li>EUR</li>
                        <li>USD</li>
                    </ul>
                </li>
                <li>ENG <span class="arrow_carrot-down"></span>
                    <ul>
                        <li>Spanish</li>
                        <li>ENG</li>
                    </ul>
                </li>
                <li><a href="#">Sign</a> <span class="arrow_carrot-down"></span></li>
            </ul>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="header__top__inner">
                            <div class="header__top__left">
                                <ul>
                                    <li>USD <span class="arrow_carrot-down"></span>
                                        <ul>
                                            <li>EUR</li>
                                            <li>USD</li>
                                        </ul>
                                    </li>
                                    <li>ENG <span class="arrow_carrot-down"></span>
                                        <ul>
                                            <li>Spanish</li>
                                            <li>ENG</li>
                                        </ul>
                                    </li>
                                    <li>
                                        @if (Auth::guest() || Auth::user()->users_roles->role_id != 3)
                                            <a href="javascript:void(0)" onclick="openLoginModal();"> Login</a>
                                        @elseif (Auth::user()->users_roles->role_id == 3)
                                            <a href="#">{{Auth::user()->name}}</a>
                                            <ul class="dropdown p-2">
                                                <li><a href="./shop-details.html" style="color: whitesmoke">Shop Details</a></li>
                                                <li><a href="./shoping-cart.html" style="color: whitesmoke">Shoping Cart</a></li>
                                                <li><a href="./checkout.html" style="color: whitesmoke">Check Out</a></li>
                                                <li><a href="./wisslist.html" style="color: whitesmoke">Wisslist</a></li>
                                                <li><a href="./Class.html" style="color: whitesmoke">Class</a></li>
                                                <li><a href="./blog-details.html" style="color: whitesmoke">Blog Details</a></li>
                                                <li><form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                            this.closest('form').submit();" style="color: whitesmoke">
                                                            Logout
                                                    </a>
                                                </form>
                                            </li>
                                            </ul>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="header__logo">
                                <a href="{{route('index')}}"><img src="{{Storage::disk('uploads')->url($setting->headerImage)}}" alt="Header Logo"></a>
                            </div>
                            <div class="header__top__right">
                                <div class="header__top__right__links">
                                    <a href="#" class="search-switch"><img src="{{asset('frontend/img/icon/search.png')}}" alt=""></a>
                                    <a href="#"><img src="{{asset('frontend/img/icon/heart.png')}}" alt=""></a>
                                </div>
                                <div class="header__top__right__cart">
                                    @if (Auth::guest())
                                        <a href="javascript:void(0)" onclick="openLoginModal();"><img src="{{asset('frontend/img/icon/cart.png')}}" alt=""> <span>0</span></a>
                                        <div class="cart__price">Cart: <span>$0.00</span></div>
                                    @else
                                        <a href="{{route('cart')}}"><img src="{{asset('frontend/img/icon/cart.png')}}" alt=""> <span>0</span></a>
                                        <div class="cart__price">Cart</div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="canvas__open"><i class="fa fa-bars"></i></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('aboutus')}}">About</a></li>
                            <li><a href="{{route('shop', [$branch->id, $branch->branchlocation])}}">Shop</a></li>
                            <li><a href="./location.html">Chef/Location</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="./shop-details.html">Shop Details</a></li>
                                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                    <li><a href="./checkout.html">Check Out</a></li>
                                    <li><a href="./wisslist.html">Wisslist</a></li>
                                    <li><a href="./Class.html">Class</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="./blog.html">Blog</a></li>
                            <li><a href="./contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    @if (session('success'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-success alert-dismissible fade show" role="alert" style="background: seagreen; color: white;">
                {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session('failure'))
        <div class="row">
            <div class="col-sm-4 ml-auto message scroll">
                <div class="alert  alert-danger alert-dismissible fade show" role="alert" style="background: rgb(134, 7, 7); color: white;">
                {{ session('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
