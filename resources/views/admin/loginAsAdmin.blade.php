@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Админ') }}</h1></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login-admin') }}">
                            @csrf
                            <label for="email">Имейл</label>
                            <input id="email" type="email" class="form-control" placeholder="email" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="password">Парола</label>
                            <input id="password" type="password" class="form-control" placeholder="password"
                                   name="password" required autocomplete="current-password">
                            <button type="submit" class="btn btn-primary">{{ __('Вход') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
