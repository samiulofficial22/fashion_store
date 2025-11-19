

@extends('front-end.layout')

@section('title', 'Quick Login')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-75 bg-light">
    <div class="card shadow-lg border-0 rounded-4" style="width: 400px;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 text-primary fw-bold">🔐 Quick Login</h3>

            <form id="quickLoginForm" action="{{ route('quick.login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="login" class="form-label fw-semibold">Email or Phone Number</label>
                    <input type="text" id="login" name="login" class="form-control" placeholder="Enter your email or phone" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    Login / Register
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    By continuing, you agree to our
                    <a href="#" class="text-decoration-none text-primary">Terms</a> &
                    <a href="#" class="text-decoration-none text-primary">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
