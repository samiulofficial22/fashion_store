<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Order counts by status
        $totalUser = User::count();
        $totalProducts = Product::count();
        $totalOrders = Orders::count();
        $pending = Orders::where('status', 'pending')->count();
        $processing = Orders::where('status', 'processing')->count();
        $completed = Orders::where('status', 'completed')->count();
        $cancelled = Orders::where('status', 'cancelled')->count();

        // Recent 5 orders
        $recentOrders = Orders::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'pending', 'processing', 'completed', 'cancelled', 'recentOrders', 'totalProducts', 'totalUser'
        ));
    }
}
