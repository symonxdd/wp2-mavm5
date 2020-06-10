<?php $user = Auth::user(); ?>

@extends('layouts.master')

@section('title')
    Delete Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>User logged in:</h1>
            <h5><strong>{{ $user->email }}</strong></h5><br>
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('user.profile_delete') }}" method="post">
                <div class="form-group">
                    <label for="password">Delete Account:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="enter password">
                </div>

                <button type="submit" class="btn btn-danger">Delete account</button>

                <!-- // DIT IS ZEKER NODIG ANDERS GEEN VALIDATIE, TRUST ME -->
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
