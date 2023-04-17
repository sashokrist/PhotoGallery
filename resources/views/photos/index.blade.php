@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">{{ __('Фото Гарлерия') }}</h1></div>
                    <div class="card-body">
                        <hr>
                        @if(count($photos) > 0)
                            <div class="row">
                                @foreach($photos as $photo)
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <a href="{{ route('photos.show', ['photo' => $photo->id]) }}">
                                                <img src="{{ asset('images/'.$photo->image) }}" width="100" height="100"
                                                     alt={{ $photo->title }}>
                                                <p class="card-text">Качено от: {{ $photo->user->name }}
                                                </p>
                                            </a>
                                            <div class="card-body">
                                                @can('delete', $photo)
                                                    <form action="{{ route('photos.destroy', $photo->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                                <p>Тагове:
                                                    @foreach ($photo->tags as $tag)
                                                        <a href="{{ route('photos.tag', ['tag' => $tag->id]) }}"
                                                           class="badge bg-primary">{{ $tag->name }} |</a>
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No photos found</p>
                        @endif
                        {{--                        {{ $photos->links('pagination::bootstrap-4') }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

