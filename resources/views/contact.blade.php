@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3 class="text-center">{{ __('Изпратини имейл.') }}</h3></div>
                    <div class="card-body">
                        <form action="" method="post" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Име</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}"
                                       name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label>Имейл</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                                       name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="text" class="form-control {{ $errors->has('phone') ? 'error' : '' }}"
                                       name="phone" id="phone">
                            </div>
                            <div class="form-group">
                                <label>Относно</label>
                                <input type="text" class="form-control {{ $errors->has('subject') ? 'error' : '' }}"
                                       name="subject"
                                       id="subject">
                            </div>
                            <div class="form-group">
                                <label>Съобщение</label>
                                <textarea class="form-control {{ $errors->has('message') ? 'error' : '' }}"
                                          name="message" id="message"
                                          rows="4"></textarea>
                            </div>
                            <input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
