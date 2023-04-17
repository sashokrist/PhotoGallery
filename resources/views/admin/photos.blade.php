@extends('layouts.app')
<style>
    /* Remove bullets from unordered list */
    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    /* Style for list items */
    li {
        margin-bottom: 10px;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Снимки') }}</h1></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Заглавие</th>
                                    <th>Снимка</th>
                                    <th>Качена от</th>
                                    <th>Качена на</th>
                                    <th>Коментари</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($photos as $photo)
                                    <tr>
                                        <td>
                                            {{ $photo->title }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/'.$photo->image) }}" width="50" height="50"
                                                 alt={{ $photo->title }}>
                                        </td>
                                        <td>{{ $photo->user->name }}</td>
                                        <td>{{ $photo->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($photo->comments->count() > 0)
                                                @foreach($photo->comments as $comment)
                                                    <ul>
                                                        <li>
                                                            <p>Общо коментари: ({{ $photo->comments->count() }})</p>
                                                            <span class="comment">{{ $comment->body }}</span><br>
                                                            <form method="post"
                                                                  action="{{ route('comments.destroy', $comment->id) }}"
                                                                  class="d-inline">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="fa-solid fa-trash"></i></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @else
                                                <p>Няма коментари за тази снимка.</p>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('photos.show', ['photo' => $photo->id]) }}"
                                               class="btn btn-primary btn-sm"><i class="fa-regular fa-eye"></i></a>
                                            <form action="{{ route('admin.deletePhoto', $photo->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Сигурен ли си че искаш да изтриеш тази снимка?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $photos->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
@endsection

