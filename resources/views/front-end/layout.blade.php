<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Organic Store') </title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
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
        <a class="navbar-brand" href="{{ route('home') }}">
           <img src="{{ asset(setting('logo')) }}" alt="Logo" style="height: 40px; width: auto;"> {{ setting('site_name') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topMenu">
            <ul class="navbar-nav ms-auto">
                <!-- Header Login Button -->
               
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
                
                 @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="display:inline; ">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        {{--<a class="nav-link" href="{{ route('login') }}">Login</a>
                         <button class="btn btn-outline-primary">
                            <i class="fa fa-user"></i> Login
                        </button>--}}
                        <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register.form') }}">Register</a>
                    </li>
                @endauth
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



<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login or Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="quickLoginForm" method="POST" action="{{ route('quick.login.post') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Enter Phone or Email</label>
            <input type="text" name="login" class="form-control" placeholder="017XXXXXXXX or example@mail.com" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Continue</button>
        </form>

        <div class="text-center my-3">
          <p class="mb-2">or</p>
          <a href="{{ route('google.login') }}" class="btn btn-danger w-100">
            <i class="fab fa-google me-2"></i> Continue with Google
          </a>
        </div>

        <div class="text-center">
          <a href="{{ route('quick.login') }}">Go to full login page →</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Login Modal -->






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('script')
   {{-- ✅ JS Section --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('quickLoginForm');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerText;
        submitBtn.disabled = true;
        submitBtn.innerText = 'Processing...';

        const data = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: data
            });

            const result = await response.json();

            if (result.success && result.redirect) {
                // ✅ Direct redirect without alert
                window.location.href = result.redirect;
            } else {
                alert(result.message || 'Login failed. Try again.');
            }

        } catch (error) {
            console.error(error);
            alert('Something went wrong. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerText = originalText;
        }
    });
});
</script>

</body>
</html>
