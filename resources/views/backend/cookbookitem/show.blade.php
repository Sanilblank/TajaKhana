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
        <h1 class="mt-3">View Cookbook Item <a href="{{ route('cookbookitem.index') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-eye" aria-hidden="true"></i> View Items</a></h1>

                        <div class="card mt-3">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 16px;">Name: {{$cookbookitem->itemname}}</p>
                                    <p style="font-size: 16px;">Category: {{$category}}</p>
                                    <p style="font-size: 16px;">View Count: {{$cookbookitem->view_count}}</p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <p style="font-size: 16px;">Recipe By: {{$cookbookitem->recipeby}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p style="font-size: 16px;">Author Image:</p>
                                            <img src="{{Storage::disk('uploads')->url($cookbookitem->recipebyimage)}}" style="max-height: 50px">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p style="font-size: 16px;">Item Image:</p>
                                    <img src="{{Storage::disk('uploads')->url($cookbookitem->itemimage)}}" style="max-height: 200px;">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 16px;">Serving: {{$cookbookitem->serving}}</p>
                                    <p style="font-size: 16px;">Time to Prepare: {{$cookbookitem->timetoprepare}}</p>
                                    <p style="font-size: 16px;">Time to Cook: {{$cookbookitem->timetocook}}</p>

                                    <p style="font-size: 16px;">Level of Cooking: {{$cookbookitem->levelofcooking->level}}</p>

                                </div>
                                <div class="col-md-6">
                                    <p style="font-size: 16px;">Course: {{$cookbookitem->course}}</p>
                                    <p style="font-size: 16px;">Cuisine: {{$cookbookitem->cuisine}}</p>
                                    <p style="font-size: 16px;">Time of Day: {{$cookbookitem->timeofday}}</p>
                                    <p style="font-size: 16px;">Recipe Type: {{$cookbookitem->recipetype->type}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="font-size: 16px;">Description: {!! $cookbookitem->description !!}</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header h5">Ingredients:</div>
                            <div class="card-body">
                                {!! $cookbookitem->ingredients !!}
                            </div>


                        </div>
                        <div class="card mt-3">
                            <div class="card-header h5">Steps to Cook:</div>
                            <div class="card-body">
                                {!! $cookbookitem->steps !!}
                            </div>


                        </div>
    </div>

@endsection
@push('scripts')

@endpush
