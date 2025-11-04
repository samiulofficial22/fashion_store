<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .invoice-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 40px auto;
            max-width: 900px;
        }
        .invoice-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .invoice-header h2 {
            color: #007bff;
        }
        .table th {
            background-color: #f1f1f1;
        }
        .totals td {
            padding: 5px 0;
        }
        @media print {
            body {
                background: white !important;
                -webkit-print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .invoice-wrapper {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>

<div class="invoice-wrapper">
    <!-- Header -->
    <div class="invoice-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-0">🧾 Invoice</h2>
            <p class="text-muted mb-0">Invoice #{{ $order->id }}</p>
            <p class="text-muted">Date: {{ $order->created_at->format('d M, Y') }}</p>
        </div>
        <div class="text-end">
            <img src="{{ asset('admin/images/logo.png') }}" alt="Logo" style="width: 100px;">
            <p class="fw-semibold mt-2 mb-0">Your Company Name</p>
            <p class="text-muted mb-0">www.yourdomain.com</p>
        </div>
    </div>

    <!-- Billing Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="fw-bold mb-2 text-secondary">Billing Details</h5>
            <p class="mb-1"><strong>Name:</strong> {{ $order->billing_name }}</p>
            <p class="mb-1"><strong>Phone:</strong> {{ $order->billing_phone }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $order->billing_email ?? 'N/A' }}</p>
            <p class="mb-0"><strong>Address:</strong> {{ $order->billing_address }}</p>
        </div>
        <div class="col-md-6 text-end">
            <h5 class="fw-bold mb-2 text-secondary">Order Summary</h5>
            <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p class="mb-1"><strong>Status:</strong> 
                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
            </p>
            <p class="mb-1"><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Product Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-start">{{ $item->product_name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="row justify-content-end">
        <div class="col-md-5">
            <table class="table table-borderless text-end totals">
                <tr>
                    <td class="fw-semibold">Subtotal:</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold">Tax:</td>
                    <td>${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr class="border-top">
                    <td class="fw-bold fs-5">Total:</td>
                    <td class="fw-bold fs-5 text-success">${{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="border-top pt-3 mt-3 text-center">
        <p class="text-muted mb-1">Thank you for your purchase!</p>
        <p class="text-muted small mb-0">If you have any questions, contact us at support@yourdomain.com</p>
    </div>

    <!-- Print Button -->
    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary px-4">
            <i class="fas fa-print me-2"></i> Print Invoice
        </button>
    </div>
</div>

</body>
</html>
