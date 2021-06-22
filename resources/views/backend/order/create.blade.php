@extends('backend.layouts.app')
@push('styles')

@endpush
@section('content')
    <div class="right_col" role="main">
        @if (session('success'))
        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if (session('failure'))
        <div class="col-sm-12">
            <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                {{ session('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        <h1 class="mt-3">Create Order <a href="{{route('order.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Orders</a></h1>
        <div class="card mt-3">

            <form action="{{route('productorder')}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">First Name: </label>
                            <input type="text" name="firstname" class="form-control" value="{{ @old('firstname') }}"
                                placeholder="Enter Firstname of Customer">
                            @error('firstname')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address: </label>
                            <input type="text" name="address" class="form-control" value="{{ @old('address') }}"
                                placeholder="Enter address of Customer">
                            @error('address')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="district">District: </label>
                            <input type="text" name="district" class="form-control" value="{{ @old('district') }}"
                                placeholder="Enter district of Customer">
                            @error('district')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone: </label>
                            <input type="text" name="phone" class="form-control" value="{{ @old('phone') }}"
                                placeholder="Enter phone no of Customer">
                            @error('phone')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Last Name: </label>
                            <input type="text" name="lastname" class="form-control" value="{{ @old('lastname') }}"
                                placeholder="Enter Lastname of Customer">
                            @error('lastname')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="town">Town: </label>
                            <input type="text" name="town" class="form-control" value="{{ @old('town') }}"
                                placeholder="Enter town of Customer">
                            @error('town')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="postcode">Post Code: </label>
                            <input type="text" name="postcode" class="form-control" value="{{ @old('postcode') }}"
                                placeholder="Enter postcode of Customer">
                            @error('postcode')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="text" name="email" class="form-control" value="{{ @old('email') }}"
                                placeholder="Enter email of Customer">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="menuitem_id">Item:</label>

                                <input list="menuitems" name="menuitem_id" placeholder="Select Item" class="form-control">
                                <datalist id="menuitems">
                                    @foreach ($menuitems as $item)
                                        <option value="{{$item->id}}">{{$item->title}} ({{$item->quantity}} {{$item->unit}})</option>
                                    @endforeach
                                </datalist>
                                @error('menuitem_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="quantity">Quantity: </label>
                            <input type="text" name="quantity" class="form-control" value="{{ @old('quantity') }}"
                                placeholder="Enter Quantity">
                            @error('quantity')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="branch_id">Branch:</label>
                            <input list="branches" name="branch_id" placeholder="Select Branch" class="form-control">
                            <datalist id="branches">
                                @foreach ($branches as $selectedbranch)
                                    <option value="{{$selectedbranch->id}}">{{$selectedbranch->branchlocation}}</option>
                                @endforeach
                            </datalist>
                            @error('branch_id')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>


                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
    </div>
    </div>

@endsection
@push('scripts')

@endpush
