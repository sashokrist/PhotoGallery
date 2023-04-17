@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ $tag_name }}</h1></div>
                    <div class="card-body">
                        @foreach ($photos as $photo)
                            <div class="col-md-4">
                                <div class="card">
                                    <a href="{{ route('photos.show', ['photo' => $photo->id]) }}">
                                        <img src="{{ asset('images/'.$photo->image) }}" width="100" height="100" alt="{{ $photo->title }}">
                                        <p class="card-text">Uploaded by: {{ $photo->user->name }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

