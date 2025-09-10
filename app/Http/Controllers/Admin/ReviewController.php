<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerReview;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = CustomerReview::with(['product', 'customer'])->get();
        return view('admin.reviews.index', compact('reviews'));
    }
    
public function updateStatus(Request $request, CustomerReview $review)
{
    $request->validate([
        'status' => 'required|string|max:255',
    ]);

    $review->status = $request->status;
    $review->save();

    return redirect()->back()->with('success', 'Review status updated successfully.');
}
}
