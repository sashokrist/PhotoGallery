@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __($photo->title) }}</h1></div>
                    <div class="card-body text-center">
                        <img src="{{ asset('images/'.$photo->image) }}" class="popup-image" width="300" height="300"
                             alt={{ $photo->title }}>
                        <div>
                            <form action="{{ route('like', $photo->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fa fa-thumbs-up"></i> {{ $countLike }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <form action="{{ route('dislike', $photo->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm">
                                        <i class="fa fa-thumbs-down"></i> {{ $countDislike }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h3 class="text-center">Коментари</h3>
                        @include('photos.commentsDisplay', ['comments' => $photo->comments, 'photo_id' => $photo->id])
                        <hr/>
                        <p>Add comment</p>
                        <form method="post" action="{{ route('comments.store'   ) }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="body" id="body" class="form-control"
                                       placeholder="Enter your comment" required>
                                <input type="hidden" name="photo_id" value="{{ $photo->id }}"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Създай коментар"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.popup-image').on('click', function () {
                var img = $(this);

                var src = img.attr('src');
                var width = img.attr('width');
                var height = img.attr('height');
                var alt = img.attr('alt');

                if (width == '600' && height == '600') {
                    img.attr('width', '300');
                    img.attr('height', '300');
                } else {
                    img.attr('width', '600');
                    img.attr('height', '600');
                }
            });
        });
    </script>
@endsection
