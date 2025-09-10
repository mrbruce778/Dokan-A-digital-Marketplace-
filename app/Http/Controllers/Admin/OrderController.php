<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerSupport;
use App\Models\Order;

class SupportController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer'])->get();
        return view('admin.orders.orders', compact('orders'));
    }
        public function updateStatus(Request $request, CustomerSupport $review)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $review->status = $request->status;
        $review->save();

        return redirect()->back()->with('success', 'Review status updated successfully.');
    }
}
