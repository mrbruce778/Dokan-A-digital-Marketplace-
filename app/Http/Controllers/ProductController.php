<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');           // search term
        $categoryId = $request->input('category'); // selected category

        // Get all categories for dropdown
        $categories = Category::all();

        // Build query for products
        $productsQuery = Product::query();

        if ($query) {
            $productsQuery->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%");
        }

        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        $products = $productsQuery->get();

        // Collect recommended products safely
        $recommendations = collect();
        foreach ($products as $product) {
            // Make sure recommendedProducts relation exists
            if (method_exists($product, 'recommendedProducts')) {
                $recommendations = $recommendations->merge($product->recommendedProducts);
            }
        }

        // Remove duplicates
        $recommendations = $recommendations->unique('product_id');

        // Return view with all necessary variables
        return view('search.results', [
            'products' => $products,
            'recommendations' => $recommendations,
            'categories' => $categories,
            'query' => $query,
            'categoryId' => $categoryId,
        ]);
    }
}
