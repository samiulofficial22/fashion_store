<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;

class OrderController extends Controller
{
    // Dashboard page
    public function dashboard()
    {
        $orders = Orders::where('user_id', Auth::id())
                        ->with('items')
                        ->latest()
                        ->get();

        return view('front-end.dashboard', compact('orders'));
    }

    // All orders list for logged-in user 
    public function index()
    {
        return $this->dashboard(); // same as dashboard
    }

    public function show(Orders $order)
    {
        // ensure user can see only their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('front-end.orders.show', compact('order'));
    }
}
