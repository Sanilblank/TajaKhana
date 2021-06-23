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
                        <h2>Change Password</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <a href="{{route('myprofile')}}">My Profile</a>
                        <span>Change Password</span>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{route('updatepassword')}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Old Password:</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="password" class="form-control" name="oldpassword" placeholder="Old Password" required><br>
                                                        @error('oldpassword')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                        @if ($message = Session::get('oldfailure'))
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @endif
                                                    </div>
                                            </div>

                                            <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">New Password:</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="password" class="form-control" name="newpassword" placeholder="New Password" required> <br>
                                                        @error('newpassword')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                        @if ($message = Session::get('samepass'))
                                                                <p class="text-danger">{{ $message }}</p>
                                                        @endif
                                                    </div>
                                            </div>

                                            <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="">Confirm Password:</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="password" class="form-control" name="newpassword_confirmation" placeholder="Confirm new Password" required> <br>
                                                        @error('newpassword_confirmation')
                                                            <p class="text-danger">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-9">
                                                    <button type="submit" class="site-btn">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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

