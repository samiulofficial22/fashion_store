@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
@auth('admin')
    @php
        $admin = auth('admin')->user();
    @endphp

    {{-- Welcome --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">Welcome, {{ $admin->name }} 👋</h2>
        <span class="badge bg-success">{{ ucfirst($admin->role) }}</span>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-bg-primary shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white">Products</h6>
                        <h3 class="text-white">120</h3>
                    </div>
                    <i class="bi bi-box fs-2 text-white"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-bg-success shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white">Orders</h6>
                        <h3 class="text-white">75</h3>
                    </div>
                    <i class="bi bi-bag fs-2 text-white"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-bg-warning shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white">Users</h6>
                        <h3 class="text-white">350</h3>
                    </div>
                    <i class="bi bi-people fs-2 text-white"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-bg-danger shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white">Revenue</h6>
                        <h3 class="text-white">$12.3K</h3>
                    </div>
                    <i class="bi bi-currency-dollar fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest Products Table --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">Latest Products</h5>
            <a href="#" class="btn btn-primary btn-sm">Add New Product</a>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Classic T-Shirt</td>
                        <td>Men</td>
                        <td>$25</td>
                        <td>50</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning mb-1 mb-md-0">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Women's Hoodie</td>
                        <td>Women</td>
                        <td>$35</td>
                        <td>30</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning mb-1 mb-md-0">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    {{-- Add more products dynamically --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Action Buttons --}}
    <div class="row g-2 g-md-3">
        <div class="col-12 col-md-4">
            <a href="#" class="btn btn-outline-primary w-100 py-3"><i class="bi bi-box me-2"></i> Manage Products</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="#" class="btn btn-outline-success w-100 py-3"><i class="bi bi-bag me-2"></i> View Orders</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="#" class="btn btn-outline-warning w-100 py-3"><i class="bi bi-people me-2"></i> Manage Users</a>
        </div>
    </div>
@else
    {{-- Redirect to login if not authenticated --}}
    <script>window.location = "{{ route('admin.login') }}";</script>
@endauth
@endsection
