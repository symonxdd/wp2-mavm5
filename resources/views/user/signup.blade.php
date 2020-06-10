@extends('layouts.master')

@section('title')
    Signup
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h1>Sign Up</h1>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
            <form action="{{ route('user.signup') }}" method="post">
                <div class="form-group">
                    <label for="email">e-mail</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="veteran@laravel.com">
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>

                <!--
                explanation:
                https://laravel.com/docs/7.x/csrf
                https://en.wikipedia.org/wiki/Cross-site_request_forgery
                -->
                {{ csrf_field() }}
            </form>
    </div>
</div>
@endsection
