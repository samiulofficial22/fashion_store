<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front-end.cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $price = $product->discount_price ?? $product->price;

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $price,
                "image" => $product->thumbnail,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

 public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);
    if(isset($cart[$id])){
        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
    }

    $subtotal = 0;
    foreach($cart as $item){
        $subtotal += $item['price'] * $item['quantity'];
    }
    $taxRate = 0.02; // 2%
    $tax = $subtotal * $taxRate;
    $grandTotal = $subtotal + $tax;

    return response()->json([
        'success' => true,
        'subtotal' => number_format($subtotal, 2),
        'tax' => number_format($tax, 2),
        'grandTotal' => number_format($grandTotal, 2),
        'cartCount' => count($cart),
    ]);
}

public function remove(Request $request, $id)
{
    $cart = session()->get('cart', []);
    if(isset($cart[$id])){
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    $subtotal = 0;
    foreach($cart as $item){
        $subtotal += $item['price'] * $item['quantity'];
    }
    $taxRate = 0.02; // 2%
    $tax = $subtotal * $taxRate;
    $grandTotal = $subtotal + $tax;

    return response()->json([
        'success' => true,
        'subtotal' => number_format($subtotal, 2),
        'tax' => number_format($tax, 2),
        'grandTotal' => number_format($grandTotal, 2),
        'cartCount' => count($cart),
    ]);
}


}
