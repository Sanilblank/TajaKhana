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
                        <h2>Otp Confirmation</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <a href="{{route('myprofile')}}">My Profile</a>
                        <span>Otp Confirmation</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <form action="{{route('otpvalidation')}}" method="get">
                                        @csrf
                                        <div class="form-group">
                                            <p>We have sent a verification code to your registered mail. Please enter the code below.
                                                Code expires in 10 minutes.
                                            </p>
                                            <input type="text" name="otpcode" class="form-control" placeholder="Enter your code." required>
                                            @error('otpcode')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                            <br>
                                            <button type="submit" name="submit" class="site-btn">Confirm</button>
                                            <a href="{{route('sendotp')}}" class="site-btn">Resend</a>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection
@push('scripts')

@endpush

