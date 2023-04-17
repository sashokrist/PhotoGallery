@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($photo === null)
            <p>No results found.</p>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><h1 class="text-center">{{ __($photo->title) }}</h1></div>
                        <div class="card-body text-center">
                            <img src="{{ asset('images/'.$photo->image) }}" width="300" height="300"
                                 alt={{ $photo->title }}>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
