@extends('front-end.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}!</h2>

    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ ++$loop->index }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                          
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
