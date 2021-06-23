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
                        <h2>Edit Address</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <a href="{{route('myaccount')}}">My Account</a>
                        <span>Edit Address</span>
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
                                    <form action="{{route('updateaddress', $address->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <p class="text-danger">* fields are compulsory.</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="firstname">First Name<span class="text-danger">*</span></label>

                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="firstname" class="form-control" value="{{$address->firstname}}">
                                                            @error('firstname')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="lastname">Last Name<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="lastname" class="form-control" value="{{$address->lastname}}">
                                                            @error('lastname')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="address">Full Address:<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="address" class="form-control" value="{{$address->address}}">
                                                            @error('address')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="town">Town/City:<span class="text-danger">*</span></label>

                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="town" class="form-control" value="{{$address->town}}">
                                                            @error('town')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="district">District:<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="district" class="form-control" value="{{$address->district}}">
                                                            @error('district')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="postcode">Post Code:<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="postcode" class="form-control" value="{{$address->postcode}}">
                                                            @error('postcode')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="phone">Phone:<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="phone" class="form-control" value="{{$address->phone}}">
                                                            @error('phone')
                                                                <p class="text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="email">Email:<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="email" class="form-control" value="{{$address->email}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mt-3">
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-10">
                                                    <button type="submit" class="site-btn">Submit</button>
                                                    {{-- <button type="submit" class="btn btn-primary py-2 px-3" style="border-radius: 20px">Save</button> --}}
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

