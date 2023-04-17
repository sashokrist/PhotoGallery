@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ $user->name }}</h1></div>
                    <div class="card-body">
                        <h3>Email: {{ $user->email }}</h3>
                        <h3>Created at: {{ $user->created_at->diffForHumans() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
