<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;

class OrderController extends Controller
{
    // List all orders
    public function index()
    {
        $orders = Orders::with('items')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Show single order
    public function show(Orders $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, Orders $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    // Invoice
    public function invoice(Orders $order)
    {
        return view('admin.orders.invoice', compact('order'));
    }
}
