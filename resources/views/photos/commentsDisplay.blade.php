@foreach($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <p>{{ $comment->body }}</p>
        <p>Кометар от: {{ $comment->user->name }}</p>
        @can('isAdmin', App\Models\User::class)
            <div class="d-flex justify-content-end">
                <form method="post" action="{{ route('comments.destroy', $comment->id) }}" class="d-inline">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn btn-danger btn-sm" value="Изтрий коментара">
                </form>
            </div>
        @endcan
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="body" class="form-control" placeholder="Enter your replay here"/>
                <input type="hidden" name="photo_id" value="{{ $photo_id }}"/>
                <input type="hidden" name="parent_id" value="{{ $comment->id }}"/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" value="Отговор"/>
            </div>
        </form>
        @include('photos.commentsDisplay', ['comments' => $comment->replies])
    </div>
@endforeach
