<?php

namespace App\Http\Controllers;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::all();
        $showCategories = true; 
        return view('categories.index', compact('categories', 'showCategories'));
    }

    /**
     * Show products in a specific category
     */
    public function showProducts($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $products = Product::where('category_id', $categoryId)
            ->with('gallery') // eager load galleries
            ->get();

        $categories = Category::all(); 
        $showCategories = false;

        return view('category.product', compact('category', 'products', 'categories', 'showCategories'));
    }

}
