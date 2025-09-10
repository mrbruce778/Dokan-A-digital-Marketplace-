<?php

namespace App\Http\Controllers;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Category;
use Exception;
use App\Models\Order;
class CartController extends Controller
{
    /**
     * Add product to cart
     */
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Please login to add items to cart');
        }

        $customerId = Auth::user()->customer_id;

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = $request->input('quantity', 1);

        // Find or create active cart
        $cart = Cart::firstOrCreate(
            ['customer_id' => $customerId, 'status' => 'active'],
            ['created_at' => now()]
        );

        // Check if product already in cart
        $existingItem = CartItem::where('cart_id', $cart->cart_id)
                                ->where('product_id', $productId)
                                ->first();

        if ($existingItem) {
            $existingItem->quantity += $quantity;
            $existingItem->save();
            $message = 'Product quantity updated in cart!';
        } else {
            $product = Product::findOrFail($productId);

            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price_at_purchase' => $product->discount_price ?? $product->price
            ]);
            $message = 'Product added to cart successfully!';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Show cart contents
     */
    public function showCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login.form');
        }

        $customerId = Auth::user()->customer_id;

        $cart = Cart::where('customer_id', $customerId)
                    ->where('status', 'active')
                    ->with('items.product')
                    ->first();

        $cartItems = $cart ? $cart->items : collect();

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->price_at_purchase * $item->quantity;
        });

        return view('cart.show', compact('cart', 'cartItems', 'total'));
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request, $cartItemId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        try {
            $customerId = Auth::user()->customer_id;

            $cartItem = CartItem::whereHas('cart', function($query) use ($customerId) {
                $query->where('customer_id', $customerId)->where('status', 'active');
            })->findOrFail($cartItemId);

            $cartItem->delete();

            return response()->json(['success' => true, 'message' => 'Item removed from cart']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove item'], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request, $cartItemId)
    {
        if (!Auth::check()) {
            return redirect()->route('cart.show')->with('error', 'Please login first');
        }

        try {
            $cartItem = CartItem::findOrFail($cartItemId);

            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return redirect()->route('cart.show')->with('success', 'Quantity updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('cart.show')->with('error', 'Failed to update quantity');
        }
    }

    /**
     * Get cart count for header display
     */
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['cart_count' => 0]);
        }

        $customerId = Auth::user()->customer_id;

        $cart = Cart::where('customer_id', $customerId)
                    ->where('status', 'active')
                    ->first();

        $cartCount = $cart ? $cart->items()->sum('quantity') : 0;

        return response()->json(['cart_count' => $cartCount]);
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $customerId = Auth::user()->customer_id;

        $cart = Cart::where('customer_id', $customerId)
                    ->where('status', 'active')
                    ->with('items.product')
                    ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }

        $total = $cart->items->sum(function($item) {
            return $item->price_at_purchase * $item->quantity;
        });

        return view('cart.checkout', [
            'cartItems' => $cart->items,
            'total' => $total
        ]);
    }
public function placeOrder(Request $request)
{
    $request->validate([
        'address' => 'required|string',
        'phone_number' => 'required|string',
        'payment_method' => 'required|integer|in:1,2,3,4',
    ]);

    $customerId = Auth::user()->customer_id;

    // Get active cart with items and products
    $cart = Cart::where('customer_id', $customerId)
                ->where('status', 'active')
                ->with('items.product')
                ->firstOrFail();

    if ($cart->items->isEmpty()) {
        return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
    }

    // Create order
    $order = Order::create([
        'total_amount'    => $cart->items->sum(fn($item) => $item->quantity * $item->product->price),
        'payment_method'  => $request->payment_method,
        'progress_status' => 'pending',
        'customer_id'     => $customerId,
        'cart_id'         => $cart->cart_id,
        'address'         => $request->address,
        'phone_number'    => $request->phone_number,
    ]);

    // Move cart items into order_items
    foreach ($cart->items as $item) {
        OrderItem::create([
            'order_id'         => $order->order_id,
            'product_id'       => $item->product_id,
            'product_name'     => $item->product->name,
            'price_at_purchase'=> $item->product->price,
            'quantity'         => $item->quantity,
        ]);
    }

    // Delete cart
    $cart->items()->delete();
    $cart->delete();

    return redirect()->route('orders.final', ['order' => $order->order_id]);
}


    public function finalCheckout($orderId)
    {
        $order = Order::with('cart.items.product')->findOrFail($orderId);

        $paymentMethods = [
            1 => 'Cash on Delivery',
            2 => 'bKash',
            3 => 'Nagad',
            4 => 'Rocket'
        ];

        return view('cart.final_checkout', compact('order', 'paymentMethods'));
    }


}
