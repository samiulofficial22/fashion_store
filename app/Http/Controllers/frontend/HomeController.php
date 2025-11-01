<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class HomeController extends Controller
{
    public function index()
    {
        // Dummy products array
        //$products = [
        //    [
        //        'name' => 'Classic T-Shirt',
        //        'price' => '$25',
        //        'image' => 'https://placehold.co/300x300?text=Product+1', 
        //    ],
        //    [
        //        'name' => 'Women Hoodie',
        //        'price' => '$35',
        //        'image' => 'https://placehold.co/300x300?text=Product+2',
        //    ],
        //    [
        //        'name' => 'Sneakers',
        //        'price' => '$60',
        //        'image' => 'https://placehold.co/300x300?text=Product+3',
        //    ],
        //    [
        //        'name' => 'Jeans',
        //        'price' => '$45',
        //        'image' => 'https://placehold.co/300x300?text=Product+4',
        //    ],
        //];

         $products = Product::latest()->take(12)->get();
        // dd($products);
        return view('front-end.home', compact('products'));
    }
    
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('front-end.product', compact('product'));
    }
}
