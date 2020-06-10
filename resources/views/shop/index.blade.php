@extends('layouts.master')

@section('title')
    Laravel Shopping Cart
@endsection

@section('content')
    @if(Session::has('success'))
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <div id="charge-message" class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>
    @endif
    @foreach($products->chunk(3) as $productChunk)
        <div class="row">
            @foreach($productChunk as $product)
                <div class="col-sm-6 col-md-4">
                    <div class="card">
                        <img src="{{ $product->imagePath }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->title }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <div class="float-left price">€ {{ $product->price }}</div>
                            <a href="{{ route('product.addToCart', ['id' => $product->id] )}}" class="btn btn-primary float-right">Add to Cart</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <!--
    sources:
    https://laravel.com/docs/7.x/pagination#paginating-eloquent-results &
    https://laravel.com/docs/7.x/pagination#displaying-pagination-results
    -->
    {{ $products->links() }}

@endsection
