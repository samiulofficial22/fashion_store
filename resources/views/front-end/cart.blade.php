@extends('front-end.layout')

@section('title', 'Cart')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">🛒 Your Cart</h2>

    @if(session('cart') && count(session('cart')) > 0)
    <table class="table table-bordered align-middle text-center" id="cartTable">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th width="120">Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($cart as $id => $item)
                @php 
                    $total = $item['price'] * $item['quantity']; 
                    $subtotal += $total;
                @endphp
                <tr data-id="{{ $id }}">
                    <td><img src="{{ asset('storage/'.$item['image']) }}" width="70" height="70" class="rounded shadow-sm"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-outline-secondary btn-sm decrease">-</button>
                            <input type="number" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm mx-2 quantity" style="width:60px;">
                            <button class="btn btn-outline-secondary btn-sm increase">+</button>
                        </div>
                    </td>
                    <td class="price">{{ number_format($item['price'], 2) }}</td>
                    <td class="total">{{ number_format($total, 2) }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm deleteItem"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-end">
        @php
            $taxRate = 0.02; // 2%
            $tax = $subtotal * $taxRate;
            $grandTotal = $subtotal + $tax;
        @endphp
        <p>Subtotal: <strong id="subtotal">{{ number_format($subtotal, 2) }}</strong> ৳</p>
        <p>Tax (2.0%): <strong id="tax">{{ number_format($tax, 2) }}</strong> ৳</p>
        <h4>Grand Total: <span id="grandTotal">{{ number_format($grandTotal, 2) }}</span> ৳</h4>
        <a href="#" class="btn btn-primary mt-2">Proceed to Checkout</a>
    </div>

    @else
        <p class="alert alert-info">Your cart is empty!</p>
    @endif
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartTable = document.getElementById('cartTable');
    const taxRate = 0.02; // 2%

    // Increase / Decrease buttons
    cartTable?.addEventListener('click', function (e) {
        const row = e.target.closest('tr');
        if (!row) return;
        const id = row.dataset.id;
        const quantityInput = row.querySelector('.quantity');
        let quantity = parseInt(quantityInput.value);

        if (e.target.classList.contains('increase')) {
            quantity++;
        } else if (e.target.classList.contains('decrease') && quantity > 1) {
            quantity--;
        } else return;

        quantityInput.value = quantity;
        updateCartQuantity(id, quantity, row);
    });

    // Manual input change
    document.querySelectorAll('.quantity').forEach(input => {
        input.addEventListener('change', function () {
            const row = this.closest('tr');
            const id = row.dataset.id;
            let quantity = parseInt(this.value);
            if(quantity < 1) quantity = 1;
            this.value = quantity;
            updateCartQuantity(id, quantity, row);
        });
    });

    // Delete button
    document.querySelectorAll('.deleteItem').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const id = row.dataset.id;

            if(!confirm('Are you sure you want to remove this item?')) return;

            fetch(`/cart/remove/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    row.remove();
                    updateTotals(data);

                    // If cart empty
                    if(document.querySelectorAll('#cartTable tbody tr').length === 0){
                        document.querySelector('#cartTable').outerHTML = '<p class="alert alert-info">Your cart is empty!</p>';
                    }
                }
            })
            .catch(err => console.error(err));
        });
    });

    // Update quantity function
    function updateCartQuantity(id, quantity, row){
        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                const price = parseFloat(row.querySelector('.price').textContent.replace(',', ''));
                const total = price * quantity;
                row.querySelector('.total').textContent = total.toFixed(2);
                updateTotals(data);
            }
        })
        .catch(err => console.error(err));
    }

    // Update totals on page
    function updateTotals(data){
        document.getElementById('subtotal').textContent = data.subtotal;
        document.getElementById('tax').textContent = data.tax;
        document.getElementById('grandTotal').textContent = data.grandTotal;
        // Update top menu cart count
    document.getElementById('cartCount').textContent = data.cartCount;
    }
});
</script>
@endpush

