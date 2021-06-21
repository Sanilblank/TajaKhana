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
    <h1 class="mt-3">Edit Employee => {{$chef->name}}</h1>
    <div class="card mt-3">
        <div class="row">
            <div class="col-md-12">
               <form action="{{route('chef.update', $chef->id)}}" method="POST" enctype="multipart/form-data" class="bg-light p-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchname">Name: </label>
                                <input type="text" name="name" class="form-control" value="{{@old('name') ? @old('name') : $chef->name}}" placeholder="Enter Employee Name">
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo">Image: </label>
                                <input type="file" name="photo" class="form-control">
                                <span class="color: red">Note*:Please leave empty to use previous photo</span>
                                @error('photo')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact">Contact No: </label>
                                <input type="text" name="contact" class="form-control" value="{{@old('contact') ? @old('contact') : $chef->contact}}" placeholder="Enter Contact No">
                                @error('contact')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branch_id">Branch:</label>
                                <select class="form-control" name="branch_id">
                                    @foreach ($branches as $isbranch)
                                        <option value="{{$isbranch->id}}" {{$isbranch->id == $chef->branch_id ? 'selected' : ''}}>{{$isbranch->branchlocation}}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook">Facebook: </label>
                                <input type="text" name="facebook" class="form-control" value="{{@old('facebook') ? @old('facebook') : $chef->facebook}}" placeholder="Enter Link">
                                @error('facebook')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="linkedin">LinkedIn: </label>
                                <input type="text" name="linkedin" class="form-control" value="{{@old('linkedin') ? @old('linkedin') : $chef->linkedin}}" placeholder="Enter Link">
                                @error('linkedin')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="youtube">Youtube: </label>
                                <input type="text" name="youtube" class="form-control" value="{{@old('youtube') ? @old('youtube') : $chef->youtube}}" placeholder="Enter Link">
                                @error('youtube')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instagram">Instagram: </label>
                                <input type="text" name="instagram" class="form-control" value="{{@old('instagram') ? @old('instagram') : $chef->instagram}}" placeholder="Enter Link">
                                @error('instagram')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea name="details" class="form-control" id="details" cols="30" rows="10"
                                    placeholder="Enter Details">{{$chef->details}}</textarea>

                                @error('details')
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
