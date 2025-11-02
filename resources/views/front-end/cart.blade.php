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
        <p>Subtotal: <strong id="subtotal">{{ number_format($subtotal, 2) }}</strong> ৳</p>
        <p>Tax (<span id="taxRateText">Loading...</span>%): <strong id="tax">0.00</strong> ৳</p>
        <h4>Grand Total: <span id="grandTotal">{{ number_format($subtotal, 2) }}</span> ৳</h4>
        <a href="{{ route('checkout.index') }}" class="btn btn-primary mt-2">Proceed to Checkout</a>
    </div>

    @else
        <p class="alert alert-info">Your cart is empty!</p>
    @endif
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const cartTable = document.getElementById('cartTable');
    let taxRate = 0.00;

    // 🧾 Fetch dynamic tax rate from DB
    await fetch('/api/tax-rate')
        .then(res => res.json())
        .then(data => {
            taxRate = parseFloat(data.tax_rate) || 0.00;
            document.getElementById('taxRateText').textContent = taxRate.toFixed(2);
            updateTotals();
        })
        .catch(err => {
            console.error('Tax rate load error:', err);
            taxRate = 2.00;
            document.getElementById('taxRateText').textContent = taxRate.toFixed(2);
            updateTotals();
        });

    // 🧮 Increase / Decrease quantity
    cartTable?.addEventListener('click', function (e) {
        const row = e.target.closest('tr');
        if (!row) return;
        const id = row.dataset.id;
        const quantityInput = row.querySelector('.quantity');
        let quantity = parseInt(quantityInput.value);

        if (e.target.classList.contains('increase')) quantity++;
        else if (e.target.classList.contains('decrease') && quantity > 1) quantity--;
        else return;

        quantityInput.value = quantity;
        updateCartQuantity(id, quantity, row);
    });

    // ✏️ Manual quantity input
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

    // ❌ Delete item
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
                    updateTotals();

                    // Update top cart count
                    const cartCount = document.getElementById('cartCount');
                    if(cartCount) cartCount.textContent = data.cartCount;

                    if(document.querySelectorAll('#cartTable tbody tr').length === 0){
                        document.querySelector('#cartTable').outerHTML = '<p class="alert alert-info">Your cart is empty!</p>';
                        document.getElementById('subtotal').textContent = '0.00';
                        document.getElementById('tax').textContent = '0.00';
                        document.getElementById('grandTotal').textContent = '0.00';
                    }
                }
            })
            .catch(err => console.error(err));
        });
    });

    // 🔄 Update Quantity
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
                updateTotals();
            }
        })
        .catch(err => console.error(err));
    }

    // 📊 Update Totals
    function updateTotals(){
        let subtotal = 0;
        document.querySelectorAll('.total').forEach(td => {
            subtotal += parseFloat(td.textContent);
        });

        const tax = subtotal * (taxRate / 100);
        const grandTotal = subtotal + tax;

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('tax').textContent = tax.toFixed(2);
        document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
    }
});
</script>
@endpush

