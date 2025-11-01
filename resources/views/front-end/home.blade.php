@extends('front-end.layout')

@section('title', 'Home')

@section('content')

    <!-- Banner Slider -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="banner" style="background-image: url('https://placehold.co/1200x600?text=slider+1');"></div>
            </div>
            <div class="carousel-item">
                <div class="banner" style="background-image: url('https://placehold.co/1200x600?text=banner+2');"></div>
            </div>
            <div class="carousel-item">
                <div class="banner" style="background-image: url('https://placehold.co/1200x600?text=banner+3');"></div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4 text-center">Featured Products</h2>
            {{--<div class="row g-4">
                @foreach($products as $product)
                    <div class="col-6 col-md-3">
                        <div class="card product-card shadow-sm">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product['name'] }}</h5>
                                <p class="card-text">{{ $product['price'] }}</p>
                                <a href="#" class="btn btn-primary btn-sm">Buy Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>--}}
           <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-sm">
                        <img src="{{ asset('storage/'.$product->thumbnail) }}" class="card-img-top" alt="">
                        <div class="card-body text-center">
                            <h6>{{ $product->name }}</h6>
                            <p class="fw-bold">{{ $product->price }} ৳</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                            </form>
                        </div>
                        </div>
                    </div>
                @endforeach
           </div>
        </div>
    </section>
@endsection
