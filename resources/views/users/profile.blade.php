@extends('layouts.app')

@section('content')
    <div class="container">
        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><h1
                                class="text-center">{{ __('Профил: '). $user->name . ' - IP: ' . $ip }}</h1>
                            <div class="text-center">
                                <form action="{{ route('admin.delete-user', $user->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        Деактивирай профила
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-2">
                                <form action="{{ route('users.update', $user->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <label for="">Промени името</label>
                                    <input type="text" name="name" class="form-control" placeholder="Име">
                                    <button type="submit" class="btn btn-primary btn-sm">Промени</button>
                                </form>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#id</th>
                                        <th scope="col">Снимка</th>
                                        <th scope="col">Заглавие</th>
                                        <th scope="col">Създадена на</th>
                                        <th scope="col">Изтрий</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($photos as $photo)
                                        <tr>
                                            <th scope="row">{{ $photo->id }}</th>
                                            <td>
                                                <a href="{{ route('photos.show', ['photo' => $photo->id]) }}">
                                                    <img src="{{ asset('images/'.$photo->image) }}" width="50"
                                                         height="50"
                                                         alt={{ $photo->title }}>
                                                </a>
                                            </td>
                                            <td>{{ $photo->title }}</td>
                                            <td>{{ $photo->created_at->format('d M Y - H:i:s') }}</td>
                                            <td>
                                                @can('delete', $photo)
                                                    <form action="{{ route('photos.destroy', $photo->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $photos->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p>Please log in to view your profile.</p>
        @endif
    </div>
@endsection
