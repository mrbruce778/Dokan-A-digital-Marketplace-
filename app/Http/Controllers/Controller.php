<?php

namespace App\Http\Controllers;

use App\Models\Category; // Import the Category model

abstract class Controller
{
    public function dashboard() {
        $categories = Category::all();
        $showCategories = true; // fetch all categories
        return view('layouts.dashboard', compact('categories', 'showCategories'));
    }
}