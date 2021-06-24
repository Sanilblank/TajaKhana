@extends('backend.layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css"
        integrity="sha256-n3YISYddrZmGqrUgvpa3xzwZwcvvyaZco0PdOyUKA18=" crossorigin="anonymous" />
        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="right_col" role="main">
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
        <h1 class="mt-3">Edit Item => {{$menuitem->title}} <a href="{{ route('menuitem.index') }}" class="btn btn-primary btn-sm"> <i
                    class="fa fa-eye" aria-hidden="true"></i> View Items</a></h1>
        <div class="card mt-3">

            <form action="{{ route('combomenu.update', $menuitem->id) }}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Item Title: </label>
                            <input type="text" name="title" class="form-control" value="{{ @old('title') ? @old('title') : $menuitem->title }}"
                                placeholder="Enter Title">
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Select Categories:</label>
                            <select class="form-control chosen-select" data-placeholder="Type categories ..." multiple name="category[]">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{in_array($category->id, $menuitem->category_id)?'selected':''}}>{{$category->title}}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="costprice">Cost Price: </label>
                            <input type="text" name="costprice" class="form-control" value="{{ @old('costprice') ? @old('costprice') : $menuitem->costprice }}"
                                placeholder="Enter Cost Price">
                            @error('costprice')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Item Price (Selling Price): </label>
                            <input type="text" name="price" class="form-control" value="{{ @old('price') ? @old('price') : $menuitem->price }}"
                                placeholder="Enter Selling Price">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="discount">Discount: </label>
                            <input type="text" name="discount" class="form-control" value="{{ @old('discount') ? @old('discount') : $menuitem->discount }}"
                                placeholder="Enter Discount">
                            @error('discount')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity: </label>
                                    <input type="text" name="quantity" class="form-control" value="{{ @old('quantity') ? @old('quantity') : $menuitem->quantity }}"
                                        placeholder="Enter Quantity">
                                    @error('quantity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Product Unit: </label>
                                    <input type="text" name="unit" class="form-control" value="{{ @old('unit') ? @old('unit') : $menuitem->unit }}"
                                        placeholder="Eg: plate, piece">
                                    @error('unit')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="menuitem_id">Select Items:</label>
                            <select class="form-control chosen-select" data-placeholder="Type items ..." multiple name="menuitem_id[]">
                                @foreach ($combomenuitems as $item)
                                    <option value="{{$item->menuitem->id}}" selected>{{$item->menuitem->title}} ({{$item->menuitem->quantity}} {{$item->menuitem->unit}})</option>
                                @endforeach
                                @foreach ($menuitems as $reqitem)
                                    <option value="{{$reqitem->id}}">{{$reqitem->title}} ({{$reqitem->quantity}} {{$reqitem->unit}})</option>
                                @endforeach
                            </select>
                            @error('menuitem_id')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Select Multiple Images</label>
                            <input type="file" name="photos[]" id="uploads" class="form-control" multiple>
                            <span class="color: red">Note*:Please leave empty to use previous photos</span>
                            @error('photos')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="details">Details</label>
                            <textarea name="details" class="form-control" id="details" cols="30" rows="10"
                                placeholder="Enter Product Details">{{$menuitem->details}}</textarea>

                            @error('details')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">Status: </label>
                                    <input type="radio" name="status" value="1" {{ $menuitem->status == 1 ? 'checked' : '' }}> Active
                                    <input type="radio" name="status" value="0" {{ $menuitem->status == 0 ? 'checked' : '' }}> Inactive

                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="featured">Featured: </label>
                                    <input type="radio" name="featured" value="1" {{ $menuitem->featured == 1 ? 'checked' : '' }}> Yes
                                    <input type="radio" name="featured" value="0" {{ $menuitem->featured == 0 ? 'checked' : '' }}> No

                                    @error('featured')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
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
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script>
        $('#details').summernote({
            height: 200,

        });

        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });

    </script>
@endpush
