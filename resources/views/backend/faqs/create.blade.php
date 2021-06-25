@extends('backend.layouts.app')
@push('styles')

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
        <h1 class="mt-3">Create Faq <a href="{{ route('faq.index') }}" class="btn btn-primary btn-sm"> <i
                    class="fa fa-eye" aria-hidden="true"></i> View Faqs</a></h1>
                            <div class="card mt-3">
                                <form action="{{route('faq.store')}}" method="POST" class="bg-light p-3">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="question">Question: </label>
                                                <input type="text" name="question" class="form-control" value="{{@old('question')}}" placeholder="Faq Question">
                                                @error('question')
                                                    <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="answer">Answer:</label>
                                                <textarea name="answer" class="form-control" cols="30" rows="10" placeholder="Faq Answer"></textarea>
                                                @error('answer')
                                                    <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </form>
                            </div>

    </div>


@endsection
@push('scripts')

@endpush
