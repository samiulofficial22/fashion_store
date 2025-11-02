@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">All Orders</h2>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
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
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user_id ? $order->user->name : $order->billing_name }} 
                        <br> <small>({{ $order->user_id ? 'Registered' : 'Guest' }})</small>
                    </td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-sm btn-success" target="_blank">Invoice</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
