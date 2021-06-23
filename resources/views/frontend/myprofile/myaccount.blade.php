@extends('frontend.layouts.app')
@push('styles')
<style>
    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
        color: seagreen;
    }
</style>
@endpush

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__text">
                        <h2>My Account</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>My Account</span>
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
                                <div class="col-md-6">
                                    <h4 class="billing-heading mt-3 mb-3">Basic Info | <a href="{{route('myprofile')}}">Edit</a></h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>Name:</b>
                                        </div>
                                        <div class="col-md-9">
                                            {{$user->name}}
                                        </div>

                                        <div class="col-md-3">
                                            <b>Email:</b>
                                        </div>
                                        <div class="col-md-9">
                                            {{$user->email}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    @if ($deliveryaddress == null)
                                    <h4 class="billing-heading mt-3 mb-3">My Address (Default)</h4>
                                        No default address.<br>
                                        Your default address will appear when you will order your first product.
                                    @else
                                    <h4 class="billing-heading mt-3 mb-3">My Address (Default) | <a href="{{route('editcustomeraddress')}}">Edit</a></h4>
                                        {{$deliveryaddress->address}}, {{$deliveryaddress->town}},<br>
                                        {{$deliveryaddress->district}} ({{$deliveryaddress->postcode}}), Nepal<br>
                                        +977 {{$deliveryaddress->phone}}
                                    @endif

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

