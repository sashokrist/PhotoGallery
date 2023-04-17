@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1 class="text-center">{{ __('Качи снимка') }}</h1></div>

                    <div class="card-body">
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
                            <a href="{{ route('photos.index') }}" class="btn btn-secondary">Отказ</a>
                            <button type="submit" class="btn btn-primary">Качи снимка</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
