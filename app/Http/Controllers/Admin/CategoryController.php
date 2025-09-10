<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Show all categories
    public function index() {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Show form to create new category
    public function create() {
        return view('admin.categories.create');
    }

    // Store new category
    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:255',
            'parent_category_id' => 'nullable|integer|exists:category,category_id',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully.');
    }

    // Show form to edit category
    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category) {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:255',
            'parent_category_id' => 'nullable|integer|exists:category,category_id',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete category
    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
