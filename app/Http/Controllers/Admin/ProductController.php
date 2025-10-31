<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show all products
   public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products', 'search'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Store new product


public function store(Request $request)
{
    $request->validate([
        'name'              => 'required|string|max:255',
        'category_id'       => 'required|exists:categories,id',
        'price'             => 'required|numeric|min:0',
        'discount'          => 'nullable|numeric|min:0|max:100',
        'stock'             => 'required|integer|min:0',
        'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'meta_title'        => 'nullable|string|max:255',
        'meta_keywords'     => 'nullable|string|max:255',
        'meta_description'  => 'nullable|string|max:500',
        'description'       => 'nullable|string',
        'status'            => 'required|in:active,inactive',
    ]);


    // 🧠 Step 1: Prepare base data
    $data = $request->except(['thumbnail', 'images']);
    $data['slug'] = Str::slug($request->name) . '-' . Str::random(6);

    // 🧮 Step 2: Calculate Discount Price
    if ($request->filled('discount') && $request->discount > 0) {
        $discountAmount = ($request->price * $request->discount) / 100;
        $data['discount_price'] = $request->price - $discountAmount;
    } else {
        $data['discount_price'] = $request->price; // no discount
    }

    // 🖼️ Step 3: Upload thumbnail
    if ($request->hasFile('thumbnail')) {
        $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnail', 'public');
    }

    // 💾 Step 4: Save product
    $product = Product::create($data);

    // 📸 Step 5: Handle gallery images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products/gallery', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
            ]);
        }
    }

    // ✅ Step 6: Redirect with success
    return redirect()->route('admin.products.index')
        ->with('success', '✅ Product created successfully with discount applied!');

 
}



    // Edit product
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

   // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'discount'          => 'nullable|numeric|min:0|max:100',
            'stock'             => 'required|integer|min:0',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'status'            => 'required|in:active,inactive',
        ]);

        $data = $request->except(['thumbnail', 'images']);

        // ✅ Discount calculation
        if ($request->filled('discount') && $request->discount > 0) {
            $discountAmount = ($request->price * $request->discount) / 100;
            $data['discount_price'] = $request->price - $discountAmount;
        } else {
            $data['discount_price'] = $request->price;
        }

        // ✅ Thumbnail replace
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && \Storage::disk('public')->exists($product->thumbnail)) {
                \Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnail', 'public');
        }

        // ✅ Update product
        $product->update($data);

        // ✅ Handle new gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', '✅ Product updated successfully!');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // Delete file from storage
        if (\Storage::disk('public')->exists($image->image_path)) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
    // Delete product
    public function destroy(Product $product)
    {
        // Delete thumbnail
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        // Delete all gallery images
        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', '🗑️ Product deleted successfully!');
    }
    
    
    public function show(Product $product)
    {
        $product->load('category', 'images'); // eager load relations
        return view('admin.products.show', compact('product'));
    }

}
