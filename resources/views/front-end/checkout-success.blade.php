
@extends('front-end.layout')

@section('title', 'Order Success')

@section('content')
<div class="container my-5">
    <div class="alert alert-success">
        <h4 class="mb-3">🎉 Order Placed Successfully!</h4>
        <p>Thank you {{ $order->billing_name }} for your purchase.</p>
        <p>Your Order ID: <strong>#{{ $order->id }}</strong></p>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5>Order Summary</h5>
        </div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Billing Name:</strong> {{ $order->billing_name }}</p>
            @if($order->billing_email)
            <p><strong>Billing Email:</strong> {{ $order->billing_email }}</p>
            @endif
            <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
            <p><strong>Address:</strong> {{ $order->billing_address }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5>Shipping Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
            @if($order->shipping_email)
            <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
            @endif
            <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
            <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5>Products</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
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

