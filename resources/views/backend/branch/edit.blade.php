@extends('backend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css"
        integrity="sha256-n3YISYddrZmGqrUgvpa3xzwZwcvvyaZco0PdOyUKA18=" crossorigin="anonymous" />
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
    <h1 class="mt-3">Edit Branch at => {{$branch->branchlocation}}  <a href="{{route('branch.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> View Branches</a></h1>
    <div class="card mt-3">
        <div class="row">
            <div class="col-md-12">
               <form action="{{route('branch.update', $branch->id)}}" method="POST" enctype="multipart/form-data" class="bg-light p-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchname">Branch Name: </label>
                                <input type="text" name="branchname" class="form-control" value="{{@old('branchname') ? @old('branchname') : $branch->branchname }}" placeholder="Enter Branch Name">
                                @error('branchname')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchlocation">Branch location: </label>
                                <input type="text" name="branchlocation" class="form-control" value="{{@old('branchlocation') ? @old('branchlocation') : $branch->branchlocation}}" placeholder="Enter Location of Branch">
                                @error('branchlocation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude: </label>
                                <input type="text" name="latitude" class="form-control" value="{{@old('latitude')  ? @old('latitude') : $branch->latitude }}" placeholder="Enter Latitude">
                                @error('latitude')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude: </label>
                                <input type="text" name="longitude" class="form-control" value="{{@old('longitude')  ? @old('longitude') : $branch->longitude }}" placeholder="Enter Longitude">
                                @error('longitude')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Contact No: </label>
                                <input type="text" name="phone" class="form-control" value="{{@old('phone') ? @old('phone') : $branch->phone }}" placeholder="Enter Contact No">
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchimage">Branch Image: </label>
                                <input type="file" name="branchimage" class="form-control">
                                <span class="color: red">Note*:Please leave empty to use previous photo</span>
                                @error('branchimage')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="status">Status: </label>
                                <input type="radio" name="status"  value="1" {{ $branch->status == 1 ? 'checked' : '' }}> Active
                                <input type="radio" name="status"  value="0" {{ $branch->status == 0 ? 'checked' : '' }}> Inactive
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
        <script>
            $('#details').summernote({
                height: 100,

            });
    </script>
@endpush
