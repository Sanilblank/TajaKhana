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
                        <h2>My Reviews</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="breadcrumb__links">
                        <a href="{{route('index')}}">Home</a>
                        <span>My Reviews</span>
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

                        @if (count($reviews) == 0)
                        <p class="ml-3">No Reviews given by you</p>
                        @endif

                                            @foreach ($reviews as $review)
                                                                @php
                                                                    $chef = DB::table('chefs')->where('id', $review->chef_id)->first();
                                                                    $currentbranch = DB::table('branches')->where('id', $chef->branch_id)->first();
                                                                @endphp

                                                                <div class="co-item">

                                                                    <h5 style="color: #b83955; margin-bottom:1rem;">Review of Chef {{$chef->name}} ({{$currentbranch->branchlocation}})</h5>
                                                                    <div class="row">
                                                                        <div class="col-md-3 text-center">
                                                                            <div class="avatar-pic">
                                                                                <img src="{{Storage::disk('uploads')->url($chef->photo)}}" alt="" style="max-width: 100px">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div class="avatar-pic">
                                                                                <div class="avatar-text">
                                                                                    <div class="at-rating mb-2">
                                                                                        @for ($i = $review->rating; $i > 0; $i--)
                                                                                            <i class="fa fa-star" style="color: #ffc107"></i>
                                                                                        @endfor
                                                                                        @for ($i =5 - $review->rating; $i > 0; $i--)
                                                                                            <i class="fa fa-star-o" style="color: grey"></i>
                                                                                        @endfor
                                                                                    </div>
                                                                                        <h5 class="mb-2">{{$chef->name}} - <span>{{$review->updated_at->diffForHumans()}}</span></h5>
                                                                                    <div class="at-reply mb-2">{{$review->description}}</div>
                                                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editreviewModal{{$chef->id . Auth::user()->id}}">&nbsp; Edit &nbsp;</button>
                                                                                        <!-- Modal -->
                                                                                        <div class="modal fade" id="editreviewModal{{$chef->id . Auth::user()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                <h5 class="modal-title" id="editreviewModalLabel">Update your Review</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                                </div>
                                                                                                <form action="{{route('updatereview', $review->id)}}" method="POST">
                                                                                                    @csrf
                                                                                                    @method('PUT')
                                                                                                    <div class="modal-body">
                                                                                                            <div class="form-group">
                                                                                                                <div class="container d-flex justify-content-center">
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-md-2">
                                                                                                                        </div>
                                                                                                                        <div class="col-md-9">
                                                                                                                            <div class="stars">
                                                                                                                                <input class="star star-5" id="starrating-5{{$chef->id . Auth::user()->id}}" type="radio" name="star" value="5"

                                                                                                                                @if ($review->rating == 5)
                                                                                                                                    checked
                                                                                                                                @endif />
                                                                                                                                <label class="star star-5" for="starrating-5{{$chef->id . Auth::user()->id}}"></label>
                                                                                                                                <input class="star star-4" id="starrating-4{{$chef->id . Auth::user()->id}}" type="radio" name="star" value="4"

                                                                                                                                @if ($review->rating == 4)
                                                                                                                                    checked
                                                                                                                                @endif />
                                                                                                                                <label class="star star-4" for="starrating-4{{$chef->id . Auth::user()->id}}"></label>
                                                                                                                                <input class="star star-3" id="starrating-3{{$chef->id . Auth::user()->id}}" type="radio" name="star" value="3"

                                                                                                                                @if ($review->rating == 3)
                                                                                                                                    checked
                                                                                                                                @endif />
                                                                                                                                <label class="star star-3" for="starrating-3{{$chef->id . Auth::user()->id}}"></label>
                                                                                                                                <input class="star star-2" id="starrating-2{{$chef->id . Auth::user()->id}}" type="radio" name="star" value="2"

                                                                                                                                @if ($review->rating == 2)
                                                                                                                                    checked
                                                                                                                                @endif />
                                                                                                                                <label class="star star-2" for="starrating-2{{$chef->id . Auth::user()->id}}"></label>
                                                                                                                                <input class="star star-1" id="starrating-1{{$chef->id . Auth::user()->id}}" type="radio" name="star" value="1"

                                                                                                                                @if ($review->rating == 1)
                                                                                                                                    checked
                                                                                                                                @endif />
                                                                                                                                <label class="star star-1" for="starrating-1{{$chef->id . Auth::user()->id}}"></label>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="col-md-12">
                                                                                                                            <textarea rows="4" cols="40" class="form-control" placeholder="Describe your experience (optional)" name="ratingdescription">{{$review->description}}</textarea>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Modal Ends -->

                                                                                        <form action="{{route('deleteuserreview', $review->id)}}" method="POST" style="display: inline;">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                                                        </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <hr>
                                                @endforeach


                        <div class="row mt-5 mb-5" style="text-align: center">
                            <div class="col-md-12">
                                {{ $reviews->links() }}
                            </div>

                        </div>

                </div>
            </div>

        </div>
    </section>


@endsection
@push('scripts')

@endpush

