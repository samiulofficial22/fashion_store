@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    @auth('admin')
        @php
            $admin = auth('admin')->user();
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Welcome, {{ $admin->name }} 👋</h2>
            <span class="badge bg-success">{{ $admin->role }}</span>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Products</h5>
                        <p class="card-text fs-4">120</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- redirect to admin login if somehow user is not logged in --}}
        <script>window.location = "{{ route('admin.login') }}";</script>
    @endauth
@endsection
