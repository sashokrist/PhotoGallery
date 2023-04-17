@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">{{ __('Снимки') }}</h1></div>
                    <div class="card-body">
                        <hr>
                        @if(count($photos) > 0)
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#id</th>
                                            <th scope="col">Снимка</th>
                                            <th scope="col">QR code</th>
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
                                                             height="50" alt={{ $photo->title }}>
                                                    </a>
                                                </td>
                                                <td><img src="data:image/svg+xml;base64,{{ $qrCodes[$photo->id] }}"
                                                         alt="QR Code"></td>
                                                <td>{{ $photo->title }}</td>
                                                <td>{{ $photo->created_at->diffForHumans() }}</td>
                                                <td>
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
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p>No photos found</p>
                        @endif
                        {{ $photos->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

