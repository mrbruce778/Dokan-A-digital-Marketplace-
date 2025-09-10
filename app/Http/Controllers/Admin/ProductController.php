<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of products for a specific category.
     */
    public function index(Category $category)
    {
        // Eager load products for this category
        $products = $category->products()->get();

        return view('admin.categories.products.index', compact('category', 'products'));
    }

    /**
     * Show the form for creating a new product in a category.
     */
    public function create(Category $category)
    {
        return view('admin.categories.products.create', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,category_id',
            'image_url' => 'nullable|url',
        ]);

        // Create product
        $product = $category->products()->create($validated);

        // Save image URL if provided
        if ($request->filled('image_url')) {
            $product->gallery()->create([
                'image_url' => $request->image_url
            ]);
        }

        return redirect()->route('admin.products.index', $category)
                        ->with('success', 'Product added successfully.');
    }


    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all(); // if you want to allow changing category
        return view('admin.categories.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:category,category_id',
            'image_url' => 'nullable|url',
        ]);

        $product->update($validated);

        // Update or create the first gallery image
        if ($request->filled('image_url')) {
            if ($product->gallery->isEmpty()) {
                // No gallery yet, create
                $product->gallery()->create([
                    'image_url' => $request->image_url
                ]);
            } else {
                // Update first gallery
                $product->gallery()->first()->update([
                    'image_url' => $request->image_url
                ]);
            }
        }

        return redirect()->route('admin.products.index', $product->category)
                        ->with('success', 'Product updated successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.categories.products.show', compact('product'));
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        $category = $product->category;
        $product->delete();

        return redirect()->route('admin.products.index', $category)
                         ->with('success', 'Product deleted successfully.');
    }
}
