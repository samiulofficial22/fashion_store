<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNewOrders()
    {
        // যেগুলোর status এখনো pending
        $orders = Orders::where('status', 'pending')->latest()->take(5)->get();

        return response()->json([
            'count' => $orders->count(),
            'orders' => $orders
        ]);
    }
}
