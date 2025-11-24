<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\TaxRateSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // get tax percent (e.g. 2.00 means 2%)
        $taxRateSetting = TaxRateSetting::first();
        $taxRatePercent = $taxRateSetting ? (float)$taxRateSetting->tax_rate : 2.00;

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax = ($subtotal * $taxRatePercent) / 100;
        $total = $subtotal + $tax;

        return view('front-end.checkout', compact('cart', 'subtotal', 'tax', 'total', 'taxRatePercent'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'nullable|email',
            'billing_phone' => 'required|string|max:50',
            'billing_address' => 'required|string|max:1000',

            'shipping_name' => 'nullable|string|max:255',
            'shipping_email' => 'nullable|email',
            'shipping_phone' => 'nullable|string|max:50',
            'shipping_address' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }

        $taxRateSetting = TaxRateSetting::first();
        $taxRatePercent = $taxRateSetting ? (float)$taxRateSetting->tax_rate : 2.00;

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax = ($subtotal * $taxRatePercent) / 100;
        $total = $subtotal + $tax;

        // ===============================
        // 🔥 Auto create user if not logged in
        // ===============================
        if (!Auth::check()) {
            // check if email already exists
            $existingUser = \App\Models\User::where('email', $request->billing_email)->first();

            if ($existingUser) {
                Auth::login($existingUser);
                $user = $existingUser;

            } else {
                // create new user
                $user = \App\Models\User::create([
                    'name' => $request->billing_name,
                    'email' => $request->billing_email,
                    'phone' => $request->billing_phone,
                    'password' => bcrypt('password123'),  // auto password
                ]);

                Auth::login($user); // auto login
            }

        } else {
            $user = Auth::user();
        }

        $userId = $user->id;
        // ===============================


        DB::beginTransaction();
        try {
            $order = Orders::create([
                'user_id' => $userId,

                'billing_name'    => $request->billing_name,
                'billing_email'   => $request->billing_email,
                'billing_phone'   => $request->billing_phone,
                'billing_address' => $request->billing_address,

                'shipping_name'    => $request->shipping_name ?: $request->billing_name,
                'shipping_email'   => $request->shipping_email ?: $request->billing_email,
                'shipping_phone'   => $request->shipping_phone ?: $request->billing_phone,
                'shipping_address' => $request->shipping_address ?: $request->billing_address,

                'subtotal' => $subtotal,
                'tax'      => $tax,
                'total'    => $total,
            ]);

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if (!$product) {
                    throw new \Exception("Product ({$productId}) not found");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for product: {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('checkout.success', $order->id);

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }



    public function success($id)
    {
        $order = Orders::with('items')->findOrFail($id);
        return view('front-end.checkout-success', compact('order'));
    }
}
