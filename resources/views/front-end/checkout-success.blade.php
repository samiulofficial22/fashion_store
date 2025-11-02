@extends('front-end.layout')

@section('title', 'Order Success')

@section('content')
<div class="container my-5 text-center">
    <h2 class="mb-4">🎉 Thank you for your order!</h2>

    <p>Order ID: <strong>#{{ $order->id }}</strong></p>
    <p>Total: <strong>{{ number_format($order->total, 2) }} ৳</strong></p>

    <h5 class="mt-4">Order Items</h5>
    <ul class="list-group my-3">
        @foreach($order->items as $it)
            <li class="list-group-item d-flex justify-content-between">
                {{ $it->product_name }} (×{{ $it->quantity }})
                <span>{{ number_format($it->total, 2) }} ৳</span>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection
