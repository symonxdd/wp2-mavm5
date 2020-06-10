<?php $user = Auth::user(); ?>

@extends('layouts.master')

@section('title')
    Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1>User logged in:</h1>
            <h6>{{ $user->email }}</h6><br>

            <!-- displaying potential errors -->
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif


            <!--
            sources:
            https://laravel.com/docs/7.x/pagination#paginating-eloquent-results &
            https://laravel.com/docs/7.x/pagination#displaying-pagination-results
            -->

            {{ $orders->links() }}

            <h5><strong>My Orders</strong></h5><br>
            @foreach($orders as $order)
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($order->cart->items as $item)
                            <li class="list-group-item">

                                {{ $item['qty']}}x {{ $item['item']['title'] }}
                                <span class="badge">€{{ $item['price'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                    <strong>Total Price: €{{ $order->cart->totalPrice }}</strong>
                </div>
                <br>
            </div>
            @endforeach
            <br>
            <hr>
            <br>
            <form action="{{ route('user.profile') }}" method="post">
                <div class="form-group">
                    <label for="email">Change E-mail:</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="{{ $user->email }}">
                </div>
                <button type="submit" class="btn btn-primary">Change email</button>

                <!-- // DIT IS ZEKER NODIG ANDERS GEEN VALIDATIE, TRUST ME -->
                {{ csrf_field() }}
            </form><br>

            <!-- <button> tags don't work, use <a> tags for things like this, TRUST me -->
            <a class="btn btn-warning" href="{{ route('user.profile_delete') }}">Delete account</a>
        </div>
    </div>
@endsection
