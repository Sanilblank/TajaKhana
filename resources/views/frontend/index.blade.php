@extends('frontend.layouts.app')
@push('styles')

@endpush

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__item set-bg" data-setbg="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <div class="hero__text">
                                <h2>Awesome food for the best prices !! </h2>
                                <a href="#" class="primary-btn">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__item set-bg" data-setbg="https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=967&q=80">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8">
                            <div class="hero__text">
                                <h2>Select the Location Nearest to you</h2>
                                <a href="#" class="primary-btn">Select Location</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <div class="cookbook__pic set-bg" data-setbg="{{Storage::disk('uploads')->url($mainbranch->branchimage)}}">

                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="#">{{$mainbranch->branchlocation}}</a></h5>

                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="#" class="read_more">View Menu</a>
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


                                  <div class="cookbook">
                                    <div class="cookbook__pic set-bg" data-setbg="{{asset('frontend/img/class/class-2.jpg')}}">
                                        <div class="label">15min</div>
                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="#">TEEN COOKING CAMP</a></h5>
                                        <span>Lorem ipsum dolor sit, amet consectetur adipisicing elit</span>
                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="#" class="read_more">Read more</a>
                                    </div>
                                </div>

                                  <div class="cookbook">
                                    <div class="cookbook__pic set-bg" data-setbg="{{asset('frontend/img/class/class-3.jpg')}}">
                                        <div class="label">15min</div>
                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="#">TEEN COOKING CAMP</a></h5>
                                        <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="#" class="read_more">Read more</a>
                                    </div>
                                </div>

                                  <div class="cookbook">
                                    <div class="cookbook__pic set-bg" data-setbg="{{asset('frontend/img/class/class-3.jpg')}}">
                                        <div class="label">15min</div>
                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="#">TEEN COOKING CAMP</a></h5>
                                        <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="#" class="read_more">Read more</a>
                                    </div>
                                </div>

                                  <div class="cookbook">
                                    <div class="cookbook__pic set-bg" data-setbg="{{asset('frontend/img/class/class-4.jpg')}}">
                                        <div class="label">15min</div>
                                    </div>
                                    <div class="cookbook__text">
                                        <h5><a href="#">TEEN COOKING CAMP</a></h5>
                                        <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                        <!-- <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p> -->
                                        <a href="#" class="read_more">Read more</a>
                                    </div>
                                </div>



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
                            & also get all the ingredients from TAJAMANDI
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
                            <div class="class__item">
                                <div class="class__item__pic set-bg" data-setbg="{{asset('frontend/img/class/class-1.jpg')}}">
                                    <div class="label">$35.00</div>
                                </div>
                                <div class="class__item__text">
                                    <h5><a href="#">ADVANCED BAKING COURSE</a></h5>
                                    <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                    <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p>
                                    <a href="#" class="read_more">Read more</a>
                                </div>
                            </div>
                            <div class="class__item">
                                <div class="class__item__pic set-bg" data-setbg="{{asset('frontend/img/class/class-2.jpg')}}">
                                    <div class="label">$35.00</div>
                                </div>
                                <div class="class__item__text">
                                    <h5><a href="#">TEEN COOKING CAMP</a></h5>
                                    <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                    <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p>
                                    <a href="#" class="read_more">Read more</a>
                                </div>
                            </div>
                            <div class="class__item">
                                <div class="class__item__pic set-bg" data-setbg="{{asset('frontend/img/class/class-1.jpg')}}">
                                    <div class="label">$35.00</div>
                                </div>
                                <div class="class__item__text">
                                    <h5><a href="#">ADVANCED BAKING COURSE</a></h5>
                                    <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                    <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p>
                                    <a href="#" class="read_more">Read more</a>
                                </div>
                            </div>
                            <div class="class__item">
                                <div class="class__item__pic set-bg" data-setbg="{{asset('frontend/img/class/class-2.jpg')}}">
                                    <div class="label">$35.00</div>
                                </div>
                                <div class="class__item__text">
                                    <h5><a href="#">TEEN COOKING CAMP</a></h5>
                                    <span>Wed 08 Apr 2020; 6.30pm - 9.30pm</span>
                                    <p>Professional course: cook’s certificate in food & wine (six weeks full-time)</p>
                                    <a href="#" class="read_more">Read more</a>
                                </div>
                            </div>


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
                <div class="categories__slider owl-carousel">
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
                </div>

            </div>
        </div>
    </div>
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-1.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Dozen Cupcakes</a></h6>
                            <div class="product__item__price">$32.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-2.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Cookies and Cream</a></h6>
                            <div class="product__item__price">$30.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-3.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Gluten Free Mini Dozen</a></h6>
                            <div class="product__item__price">$31.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-4.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Cookie Dough</a></h6>
                            <div class="product__item__price">$25.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-5.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Vanilla Salted Caramel</a></h6>
                            <div class="product__item__price">$05.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-6.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">German Chocolate</a></h6>
                            <div class="product__item__price">$14.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-7.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Dulce De Leche</a></h6>
                            <div class="product__item__price">$32.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/shop/product-8.jpg')}}">
                            <div class="product__label">
                                <span>Cupcake</span>
                            </div>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Mississippi Mud</a></h6>
                            <div class="product__item__price">$08.00</div>
                            <div class="cart_add">
                                <a href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6 pb-4 text-center pb-4">
                    <div class="about__text">
                        <div class="section-title">
                            <span><u>View Full Menu</u></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Class Section Begin -->
    <section class="class spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="class__form">
                        <div class="section-title">
                            <span>Class cakes</span>
                            <h2>Made from your <br />own hands</h2>
                        </div>
                        <form action="#">
                            <input type="text" placeholder="Name">
                            <input type="text" placeholder="Phone">
                            <select>
                                <option value="">Studying Class</option>
                                <option value="">Writting Class</option>
                                <option value="">Reading Class</option>
                            </select>
                            <input type="text" placeholder="Type your requirements">
                            <button type="submit" class="site-btn">registration</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="class__video set-bg" data-setbg="{{asset('frontend/img/class-video.jpg')}}">
                <a href="https://www.youtube.com/watch?v=8PJ3_p7VqHw&list=RD8PJ3_p7VqHw&start_radio=1"
                class="play-btn video-popup"><i class="fa fa-play"></i></a>
            </div>
        </div>
    </section>
    <!-- Class Section End -->

    <!-- Team Section Begin -->
    <section class="team spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7">
                    <div class="section-title">
                        <span>Our team</span>
                        <h2>Sweet Baker </h2>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="team__btn">
                        <a href="#" class="primary-btn">Join Us</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item set-bg" data-setbg="{{asset('frontend/img/team/team-1.jpg')}}">
                        <div class="team__item__text">
                            <h6>Randy Butler</h6>
                            <span>Decorater</span>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item set-bg" data-setbg="{{asset('frontend/img/team/team-2.jpg')}}">
                        <div class="team__item__text">
                            <h6>Randy Butler</h6>
                            <span>Decorater</span>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item set-bg" data-setbg="{{asset('frontend/img/team/team-3.jpg')}}">
                        <div class="team__item__text">
                            <h6>Randy Butler</h6>
                            <span>Decorater</span>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team__item set-bg" data-setbg="{{asset('frontend/img/team/team-4.jpg')}}">
                        <div class="team__item__text">
                            <h6>Randy Butler</h6>
                            <span>Decorater</span>
                            <div class="team__item__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <div class="col-lg-6">
                        <div class="testimonial__item">
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{asset('frontend/img/testimonial/ta-1.jpg')}}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Kerry D.Silva</h5>
                                    <span>New york</span>
                                </div>
                            </div>
                            <div class="rating">
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star-half_alt"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua viverra lacus vel facilisis.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial__item">
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{asset('frontend/img/testimonial/ta-2.jpg')}}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Kerry D.Silva</h5>
                                    <span>New york</span>
                                </div>
                            </div>
                            <div class="rating">
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star-half_alt"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua viverra lacus vel facilisis.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial__item">
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{asset('frontend/img/testimonial/ta-1.jpg')}}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Ophelia Nunez</h5>
                                    <span>London</span>
                                </div>
                            </div>
                            <div class="rating">
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star-half_alt"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua viverra lacus vel facilisis.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial__item">
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{asset('frontend/img/testimonial/ta-2.jpg')}}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Kerry D.Silva</h5>
                                    <span>New york</span>
                                </div>
                            </div>
                            <div class="rating">
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star-half_alt"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua viverra lacus vel facilisis.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial__item">
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{asset('frontend/img/testimonial/ta-1.jpg')}}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Ophelia Nunez</h5>
                                    <span>London</span>
                                </div>
                            </div>
                            <div class="rating">
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star-half_alt"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua viverra lacus vel facilisis.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial__item">
                            <div class="testimonial__author">
                                <div class="testimonial__author__pic">
                                    <img src="{{asset('frontend/img/testimonial/ta-2.jpg')}}" alt="">
                                </div>
                                <div class="testimonial__author__text">
                                    <h5>Kerry D.Silva</h5>
                                    <span>New york</span>
                                </div>
                            </div>
                            <div class="rating">
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star"></span>
                                <span class="icon_star-half_alt"></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua viverra lacus vel facilisis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 p-0">
                    <div class="instagram__text">
                        <div class="section-title">
                            <span>Follow us on instagram</span>
                            <h2>Sweet moments are saved as memories.</h2>
                        </div>
                        <h5><i class="fa fa-instagram"></i> @sweetcake</h5>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="{{asset('frontend/img/instagram/instagram-1.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic middle__pic">
                                <img src="{{asset('frontend/img/instagram/instagram-2.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="{{asset('frontend/img/instagram/instagram-3.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="{{asset('frontend/img/instagram/instagram-4.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic middle__pic">
                                <img src="{{asset('frontend/img/instagram/instagram-5.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                            <div class="instagram__pic">
                                <img src="{{asset('frontend/img/instagram/instagram-3.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->



     <!-- Partner Logo Section Begin -->
     <div class="partner-logo">
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
    </div>
    <!-- Partner Logo Section End -->

    <!-- Map Begin -->
    <div class="map">
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
    </div>
    <!-- Map End -->

@endsection
@push('scripts')

@endpush




