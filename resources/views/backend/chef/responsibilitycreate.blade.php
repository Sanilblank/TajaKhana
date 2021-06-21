@extends('backend.layouts.app')
@push('styles')
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
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
    <h1 class="mt-3">Add Menu Items <a href="{{route('chefresponsibility.index', $chef->id)}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Back to Responsibilities</a></h1>
    <div class="card mt-3">
        <div class="row">
            <div class="col-md-12">
               <form action="{{route('chefresponsibility.store')}}" method="POST" class="bg-light p-3">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <p class="h3">Name of Chef: {{$chef->name}}</p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="h3">Location of Branch: {{$chef->branch->branchlocation}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" value="{{$chef->id}}" name="chef_id">
                                <label for="branchmenu_id" style="font-size: 28px">Select Items:</label>
                                <select class="form-control chosen-select" data-placeholder="Type items ..." multiple name="branchmenu_id[]">
                                    @foreach ($branchmenuitems as $branchmenuitem)
                                        <option value="{{$branchmenuitem->id}}">{{$branchmenuitem->menuitem->title}}</option>
                                    @endforeach
                                </select>
                                @error('branchmenu_id')
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
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script>
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });
    </script>
@endpush

