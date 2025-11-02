@extends('admin.layout')

@section('title', 'Invoice')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Invoice #{{ $order->id }}</h2>

    <div class="card p-4">
        <h4>Billing Info</h4>
        <p><strong>Name:</strong> {{ $order->billing_name }}</p>
        <p><strong>Email:</strong> {{ $order->billing_email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
        <p><strong>Address:</strong> {{ $order->billing_address }}</p>

        <hr>
        <h4>Products</h4>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>${{ number_format($item->price,2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->total,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <p>Subtotal: ${{ number_format($order->subtotal,2) }}</p>
            <p>Tax: ${{ number_format($order->tax,2) }}</p>
            <h4>Total: ${{ number_format($order->total,2) }}</h4>
        </div>

        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
        </div>
    </div>
</div>
@endsection
