@extends('layouts.master')

@section('title')
    Signin
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>Login</h1>
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('user.signin') }}" method="post">
                <div class="form-group">
                    <label for="email">e-mail</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="veteran@laravel.com">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
