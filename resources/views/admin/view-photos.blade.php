@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Снимки качени от: ') . $user->name }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($photos as $photo)
                                <div class="col-md-4">
                                    <div class="card">
                                        <img src="{{ asset('images/'.$photo->image) }}" class="card-img-top"
                                             alt="{{ $photo->title }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $photo->title }}</h5>
                                            <p class="card-text">{{ $photo->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

