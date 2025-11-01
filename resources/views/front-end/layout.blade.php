<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Navbar */
        .navbar-nav .nav-link {
            margin-right: 15px;
        }
        /* Banner */
        .banner {
            height: 600px;
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
				<li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Cart (<span id="cartCount">{{ session('cart') ? count(session('cart')) : 0 }}</span>)
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

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
@stack('script')
</body>
</html>
