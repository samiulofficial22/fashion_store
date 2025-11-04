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
        $user = Auth::user();
        $orders = Orders::where('user_id', $user->id)
                        ->with('items')
                        ->latest()
                        ->get();

        return view('front-end.dashboard', compact('orders', 'user'));
    }

    // All orders list for logged-in user 
    public function index()
    {
       return redirect()->route('home'); // same as dashboard
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
