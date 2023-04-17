@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Статистика') }}</h1></div>
                    <div class="card-body">
                        <h3>Последните 5 регистрирани потребителя </h3>
                        <ul>
                            @foreach($latestUsers as $user)
                                <li>{{ $user->name }} - {{ $user->email }}</li>
                            @endforeach
                        </ul>
                        <h3>Последните 5 качени снимки</h3>
                        <ul>
                            @foreach($latestPhotos as $photo)
                                <li>{{ $photo->title }} - качена от: {{ $photo->user->name }} - качена
                                    на: {{ $photo->created_at->diffForHumans() }}</li>
                            @endforeach
                        </ul>
                        <h2>5те най харесвани снимки</h2>
                        <ul>
                            @foreach ($mostLikedPhotos as $photo)
                                <li>
                                    <strong>{{ $photo->title }}</strong>
                                    <p>Likes: {{ $photo->likes_count }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection

