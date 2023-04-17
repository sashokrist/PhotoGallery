<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PhotoTask') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
            integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form action="{{ route('photos.search') }}" method="GET">
                <input type="text" name="search" placeholder="Снимка:име">
                <button class="btn btn-info" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <form action="{{ route('users.search') }}" method="GET">
                <input type="text" name="search" placeholder="Потребител:име/имейл">
                <button class="btn btn-info" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a class="nav-link" href="{{ route('statistics') }}"><i
                                    class="fa-solid fa-house-chimney"></i></a>
                            <a class="nav-link" href="{{ route('admin-photos') }}">{{ __('Снимки') }}</i></a>
                            <a class="nav-link" href="{{ route('admin.users') }}">{{ __('Потребители') }}</a>
                        @else
                            <a class="nav-link" href="{{ route('photos.index') }}"><i
                                    class="fa-solid fa-house-chimney"></i></a>
                            <a class="nav-link" href="{{ route('photos.photos') }}">{{ __('Снимки') }}</a>
                            <a class="nav-link" href="{{ route('users.index') }}">{{ __('Потребители') }}</a>
                            <a class="nav-link" href="{{ route('contact') }}">{{ __('Контакти') }}</a>
                            <a class="nav-link" href="{{ route('admin') }}">{{ __('Админ') }}</a>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                Качи снимка
                            </button>
                        @endif
                    @endauth

                <!-- Authentication Links -->
                    @guest
                        <a class="nav-link" href="{{ route('photos.index') }}"><i class="fa-solid fa-house-chimney"></i></a>
                        <a class="nav-link" href="{{ route('photos.photos') }}">{{ __('Снимки') }}</a>
                        <a class="nav-link" href="{{ route('users.index') }}">{{ __('Потребители') }}</a>
                        <a class="nav-link" href="{{ route('contact') }}">{{ __('Контакти') }}</a>
                        <a class="nav-link" href="{{ route('admin') }}">{{ __('Админ') }}</a>
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Влез') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="{{ route('users.profile') }}">{{ __('Профил') }}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Изход') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
    @include('showNotification')
    @yield('content')
    <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Качи снимка</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Заглавие</label>
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title') }}" placeholder="Въведи заглавието тук" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Избери снимка</label>
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tags">Тагове</label>
                                <select name="tags[]" id="tags" class="form-control" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отказ</button>
                                <button type="submit" class="btn btn-primary">Качи снимка</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
<script>
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
</html>
