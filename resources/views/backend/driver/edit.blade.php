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
    <h1 class="mt-3">Edit Driver => {{$driver->fullname}} <a href="{{route('driver.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> View Drivers</a></h1>
    <div class="card mt-3">
        <div class="row">
            <div class="col-md-12">
               <form action="{{route('driver.update', $driver->id)}}" method="POST" enctype="multipart/form-data" class="bg-light p-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullname">Full Name: </label>
                                <input type="text" name="fullname" class="form-control" value="{{@old('fullname') ? @old('fullname') : $driver->fullname}}" placeholder="Enter Name">
                                @error('fullname')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address: </label>
                                <input type="text" name="address" class="form-control" value="{{@old('address') ? @old('address') : $driver->address}}" placeholder="Enter Address">
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email: </label>
                                <input type="text" name="email" class="form-control" value="{{@old('email') ? @old('email') : $driver->email}}" placeholder="Enter Email">
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Contact No: </label>
                                <input type="text" name="phone" class="form-control" value="{{@old('phone') ? @old('phone') : $driver->phone}}" placeholder="Enter Contact No">
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo">Photo: </label>
                                <input type="file" name="photo" class="form-control">
                                <span class="color: red">Note*:Please leave empty to use previous photo</span>
                                @error('photo')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="citizenship">Citizenship: </label>
                                <input type="file" name="citizenship" class="form-control">
                                <span class="color: red">Note*:Please leave empty to use previous document</span>
                                @error('citizenship')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="license">License: </label>
                                <input type="file" name="license" class="form-control">
                                <span class="color: red">Note*:Please leave empty to use previous document</span>
                                @error('license')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status">Status: </label>
                                <input type="radio" name="status"  value="1" {{$driver->status == 1 ? 'checked' : ''}}> Active
                                <input type="radio" name="status"  value="0" {{$driver->status == 0 ? 'checked' : ''}}> Inactive
                                @error('status')
                                    <p class="text-danger">{{ $message }}</p>
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
