<!-- Footer Section Begin -->
<footer class="footer set-bg" data-setbg="{{asset('frontend/img/footer-bg.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>BRANCH INFO</h6>
                    <ul>
                        <li>{{$branch->branchname}}</li>
                        <li>Location: {{$branch->branchlocation}}</li>
                        <li>Phone: {{$branch->phone}}</li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="#"><img src="{{asset('frontend/img/footer-logo.png')}}" alt=""></a>
                    </div>
                    {{-- <p>Lorem ipsum dolor amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore dolore magna aliqua.</p> --}}
                    <div class="footer__social">
                        <a href="{{$setting->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="{{$setting->linkedin}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="{{$setting->instagram}}" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="{{$setting->youtube}}" target="_blank"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer__newslatter">
                    <h6>Subscribe</h6>
                    <p>Get latest updates and offers.</p>
                    <form action="{{route('registerSubscriber')}}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="email" name="email" placeholder="Enter your mail">
                        <button type="submit"><i class="fa fa-send-o"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <p class="copyright__text text-white"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="#" target="_blank">TajaKhana</a>
                      <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  </p>
              </div>
              <div class="col-lg-5">
                <div class="copyright__widget">
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Site Map</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
<div class="h-100 d-flex align-items-center justify-content-center">
    <div class="search-close-switch">+</div>
    <form class="search-model-form">
        <input type="text" id="search-input" placeholder="Search here.....">
    </form>
</div>
</div>
<!-- Search End -->
