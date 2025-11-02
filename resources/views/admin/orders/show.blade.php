@extends('admin.layout')

@section('title', 'Order Details')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Order #{{ $order->id }}</h2>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Customer Info</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->user_id ? $order->user->name : $order->billing_name }}</p>
            <p><strong>Email:</strong> {{ $order->billing_email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
            <p><strong>Address:</strong> {{ $order->billing_address }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Products</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
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
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body text-end">
            <p>Subtotal: ${{ number_format($order->subtotal,2) }}</p>
            <p>Tax: ${{ number_format($order->tax,2) }}</p>
            <h4>Total: ${{ number_format($order->total,2) }}</h4>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Update Status</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                @csrf
                <div class="input-group">
                    <select name="status" class="form-select">
                        @foreach(['pending','processing','completed','cancelled'] as $status)
                            <option value="{{ $status }}" @if($order->status==$status) selected @endif>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-end">
        <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-success">View Invoice</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
