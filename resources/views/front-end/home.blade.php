<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My E-Commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Navbar */
        .navbar-nav .nav-link {
            margin-right: 15px;
        }
        /* Banner */
        .banner {
            height: 400px;
            background-size: cover;
            background-position: center;
        }
        /* Product card */
        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        /* Footer */
        footer {
            background: #343a40;
            color: white;
            padding: 40px 0;
        }
        footer a {
            color: #f8f9fa;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Top Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">MyStore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Banner Slider -->
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="banner" style="background-image: url('https://placehold.co/1200x400?text=banner+1');"></div>
        </div>
        <div class="carousel-item">
            <div class="banner" style="background-image: url('https://placehold.co/1200x400?text=banner+2');"></div>
        </div>
        <div class="carousel-item">
            <div class="banner" style="background-image: url('https://placehold.co/1200x400?text=banner+3');"></div>
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
        <div class="row g-4">
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
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>MyStore</h5>
                <p>© 2025 MyStore. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="me-3">Privacy Policy</a>
                <a href="#" class="me-3">Terms of Service</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
