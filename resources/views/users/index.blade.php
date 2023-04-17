@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Потребители') }}</h1></div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Потребител</th>
                                <th scope="col">Снимки</th>
                                <th scope="col">Роля</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->photos_count }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span style="background-color: green; color: white">Admin</span>
                                        @else
                                            <span style="background-color: blue; color: white">Regular User</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    </div>
@endsection
