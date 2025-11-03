@extends('front-end.layout')

@section('title', 'Order Details')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Order #{{ $order->id }} Details</h2>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Billing & Shipping Info</div>
        <div class="card-body">
            <p><strong>Billing Name:</strong> {{ $order->billing_name }}</p>
            <p><strong>Billing Email:</strong> {{ $order->billing_email ?? 'N/A' }}</p>
            <p><strong>Billing Phone:</strong> {{ $order->billing_phone }}</p>
            <p><strong>Billing Address:</strong> {{ $order->billing_address }}</p>
            <hr>
            <p><strong>Shipping Name:</strong> {{ $order->shipping_name }}</p>
            <p><strong>Shipping Email:</strong> {{ $order->shipping_email ?? 'N/A' }}</p>
            <p><strong>Shipping Phone:</strong> {{ $order->shipping_phone }}</p>
            <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Products</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Order Date</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Subtotal</th>
                        <th>${{ number_format($order->subtotal, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3">Tax</th>
                        <th>${{ number_format($order->tax, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>${{ number_format($order->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>
@endsection
