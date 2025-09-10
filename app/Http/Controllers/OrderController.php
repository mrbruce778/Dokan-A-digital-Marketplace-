<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CustomerReview;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Cart;

class OrderController extends Controller
{
    // Show all orders for the logged-in customer
    public function index()
    {
        $customerId = Auth::user()->customer_id;

        // Get orders with their items
        $orders = Order::with('items')->where('customer_id', $customerId)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('customer.orders.index', compact('orders'));
    }
    public function adminindex()
    {
        $orders = Order::with(['customer'])->get();
        return view('admin.orders.orders', compact('orders'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $order->progress_status = $request->status;
        $order->save();

        // If admin marks order as completed
        if ($request->status === 'completed') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->update(['status' => 'sold']);
                }
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    // Cancel a pending order
    public function cancel($orderId)
    {
        $customerId = Auth::user()->customer_id;

        $order = Order::where('order_id', $orderId)
                      ->where('customer_id', $customerId)
                      ->firstOrFail();

        if ($order->progress_status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be canceled.');
        }

        $order->progress_status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Order canceled successfully.');
    }

    // Return a completed order
    public function return($orderId)
    {
        $customerId = Auth::user()->customer_id;

        $order = Order::where('order_id', $orderId)
                      ->where('customer_id', $customerId)
                      ->firstOrFail();

        if ($order->progress_status !== 'completed') {
            return redirect()->back()->with('error', 'Only completed orders can be returned.');
        }

        $order->progress_status = 'returned';
        $order->save();

        return redirect()->back()->with('success', 'Return request submitted successfully.');
    }

    // Feedback form page
    public function feedbackForm($orderId)
    {
        $customerId = Auth::user()->customer_id;

        $order = Order::with('items.product') // load order items, not cart
                    ->where('order_id', $orderId)
                    ->where('customer_id', $customerId)
                    ->firstOrFail();

        if ($order->progress_status !== 'completed') {
            return redirect()->back()->with('error', 'Feedback can only be given for completed orders.');
        }

        return view('customer.reviews', compact('order'));
    }

public function submitFeedback(Request $request, Order $order)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review_text' => 'nullable|string|max:1000',
    ]);

    $customerId = Auth::user()->customer_id;

    // Loop through all items in the order
    foreach ($order->items as $item) {
        CustomerReview::create([
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'review_date' => now(),
            'product_id' => $item->product_id,
            'customer_id' => $customerId,
        ]);
    }

    // Optionally mark order as reviewed
    $order->reviewed = true;
    $order->save();

    return redirect()->route('customer.orders.index')
                     ->with('success', 'Your feedback has been submitted for all products in this order.');
}
}
