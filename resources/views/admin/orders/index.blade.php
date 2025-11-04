@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <!-- Header -->
        <div class="card-header bg-primary text-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center">
            <h4 class="mb-2 mb-md-0"><i class="fas fa-shopping-bag me-2"></i> All Orders</h4>

            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <!-- Filter Dropdown -->
                <select name="status" class="form-select form-select-sm w-auto">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Processing</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                </select>

                <!-- Search -->
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm w-auto" placeholder="🔍 Search...">

                <!-- Submit Button -->
                <button class="btn btn-light btn-sm" type="submit"><i class="fas fa-filter me-1"></i> Apply</button>

                <!-- Reset Button -->
                @if(request('status') || request('search'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-rotate-left"></i> Reset
                </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="card-body p-4">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>
                                        <div class="fw-semibold">{{ $order->user_id ? $order->user->name : $order->billing_name }}</div>
                                        <small class="text-muted">{{ $order->user_id ? 'Registered User' : 'Guest Checkout' }}</small>
                                    </td>
                                    <td class="fw-semibold text-success">${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ][$order->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }} px-3 py-2 text-uppercase">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="btn btn-sm btn-outline-primary me-1">
                                           <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.orders.invoice', $order->id) }}" 
                                           class="btn btn-sm btn-outline-success" 
                                           target="_blank">
                                           <i class="fas fa-file-invoice"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <h5>No Orders Found</h5>
                    <p class="small">Try adjusting filters or search again.</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="card-footer text-end bg-light py-3 px-4">
            <small class="text-muted">Total Orders: <strong>{{ $orders->count() }}</strong></small>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: 0.2s ease;
    }
    .badge {
        font-size: 0.8rem;
    }
    .card {
        border-radius: 12px;
    }
</style>
@endpush
@endsection
