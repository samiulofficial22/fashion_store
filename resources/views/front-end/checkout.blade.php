@extends('front-end.layout')

@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Billing -->
            <div class="col-md-6">
                <h4>Billing Details</h4>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="billing_name" value="{{ old('billing_name', auth()->user()->name ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="billing_email" value="{{ old('billing_email', auth()->user()->email ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="billing_phone" value="{{ old('billing_phone') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="billing_address" class="form-control" required>{{ old('billing_address') }}</textarea>
                </div>
            </div>

            <!-- Shipping -->
            <div class="col-md-6">
                <h4>Shipping Details</h4>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="sameAsBilling" checked>
                    <label class="form-check-label" for="sameAsBilling">Same as Billing Address</label>
                </div>

                <div id="shippingFields" style="display:none;">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="shipping_email" value="{{ old('shipping_email') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="shipping_address" class="form-control">{{ old('shipping_address') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row mt-3">
            <div class="col-md-6">
                <h4>Order Summary</h4>
                <ul class="list-group mb-3">
                    @foreach($cart as $id => $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item['name'] }} × {{ $item['quantity'] }}
                            <span>{{ number_format($item['price'] * $item['quantity'], 2) }} ৳</span>
                        </li>
                    @endforeach

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Subtotal</strong>
                        <span>{{ number_format($subtotal, 2) }} ৳</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Tax ({{ $taxRatePercent }}%)</strong>
                        <span>{{ number_format($tax, 2) }} ৳</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>{{ number_format($total, 2) }} ৳</strong>
                    </li>
                </ul>

                <button type="submit" class="btn btn-success w-100">Place Order</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sameCheckbox = document.getElementById('sameAsBilling');
    const shippingFields = document.getElementById('shippingFields');

    sameCheckbox.addEventListener('change', () => {
        shippingFields.style.display = sameCheckbox.checked ? 'none' : 'block';
    });
});
</script>
@endpush
