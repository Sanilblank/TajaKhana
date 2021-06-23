@extends('frontend.layouts.app')
@push('styles')

@endpush

@section('content')
    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="map">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-4 col-md-7">
                            <div class="map__inner">
                                {{-- <h6>COlorado</h6>
                                <ul>
                                    <li>1000 Lakepoint Dr, Frisco, CO 80443, USA</li>
                                    <li>Sweetcake@support.com</li>
                                    <li>+1 800-786-1000</li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="map__iframe">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14130.924632367776!2d85.288939!3d27.6947029!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x6d1869a0ae5929c4!2sRevo%20Deals!5e0!3m2!1sen!2snp!4v1602757836250!5m2!1sen!2snp" height="300" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <h3>Our Branches</h3>
                </div>
            </div>
            <div class="contact__address">
                <div class="row">
                    @foreach ($branches as $currentbranch)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="contact__address__item">
                                <h6>{{$currentbranch->branchname}}</h6>
                                <ul>
                                    <li>
                                        <span class="icon_pin_alt"></span>
                                        <p>{{$currentbranch->branchlocation}}</p>
                                    </li>
                                    <li><span class="icon_headphones"></span>
                                        <p>{{$currentbranch->phone}}</p>
                                    </li>
                                    {{-- <li><span class="icon_mail_alt"></span>
                                        <p>{{$se}}</p>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact__text">
                        <h3>Contact With us</h3>
                        <ul>
                            <li>Representatives or Advisors are available:</li>
                            <li>Mon-Fri: 5:00am to 9:00pm</li>
                            <li>Sat-Sun: 6:00am to 9:00pm</li>
                        </ul>
                        <img src="img/cake-piece.png" alt="">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="contact__form">
                        <form action="{{route('customerEmail')}}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Name" name="fullname">
                                    @error('fullname')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Email" name="customeremail">
                                    @error('customeremail')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <textarea placeholder="Message" name="message"></textarea>
                                    @error('message')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <button type="submit" class="site-btn">Send Us</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

@endsection
@push('scripts')

@endpush
