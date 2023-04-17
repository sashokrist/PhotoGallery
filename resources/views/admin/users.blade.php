@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Потребители') }}</h1></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Име</th>
                                    <th>Имейл</th>
                                    <th>Създадено на</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
                                        @if ($user->deleted_at) <!-- Check if user is soft-deleted -->
                                            <form action="{{ route('admin.activate-user', $user->id) }}" method="POST"
                                                  style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Активирай</button>
                                            </form>
                                            <button class="btn btn-warning btn-sm" disabled>Деактивирай</button>
                                            @else
                                                <a href="{{ route('admin.view-photos', $user->id) }}"
                                                   class="btn btn-info btn-sm">Покажи снимките</a>
                                                <form action="{{ route('admin.delete-user', $user->id) }}" method="POST"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                                        Деактивирай
                                                    </button>
                                                </form>
                                                <button class="btn btn-success btn-sm" disabled>Активирай</button>
                                            @endif
                                            <form action="{{ route('admin.delete-user-permanently', $user->id) }}"
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this user permanently?')">
                                                    Изтрий потребителя
                                                </button>
                                            </form>
                                            @if (!$user->is_admin)
                                                <form action="{{ route('admin.make-admin', $user->id) }}" method="POST"
                                                      style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Make Admin
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

