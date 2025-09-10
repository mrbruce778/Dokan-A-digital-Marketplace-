<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login.form');
    }

    // Check if user is admin
    return Auth::user()->is_admin
        ? redirect()->route('admin.dashboard')
        : redirect()->route('dashboard');
});
/*
|--------------------------------------------------------------------------
| Contact Page
|--------------------------------------------------------------------------
*/
Route::get('/contact', function () {
    return view('contact');
});

/*
|--------------------------------------------------------------------------
| Form Submission Example
|--------------------------------------------------------------------------
*/
Route::post('/namesubmit', function(Request $request) {
    $data = $request->validate([
        'fullname' => 'required|string|min:3|max:255',
        'email' => 'required|email|max:255'
    ]);

    return "Your fullname is {$data['fullname']}, and your email is {$data['email']}";
})->name('namesubmit');

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

/*
|--------------------------------------------------------------------------
| Logout Route
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $categories = DB::table('category')->get();
    $showCategories = true;  // ← add this line
    return view('dashboard', compact('categories', 'showCategories'));
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Category & Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/category/{id}', [CategoryController::class, 'showProducts'])->name('category.products');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::post('/cart/place-order', [CartController::class, 'placeOrder'])->name('orders.place');
    Route::get('/cart/final-checkout/{order}', [CartController::class, 'finalCheckout'])->name('orders.final');
});

/*
|--------------------------------------------------------------------------
| Customer Accounts
|--------------------------------------------------------------------------
*/
Route::get('/customer/accounts', function () {
    if (!Auth::check()) return redirect()->route('login.form');

    $user = Auth::user();
    $customer = DB::table('customer')->where('customer_id', $user->customer_id)->first();

    // Fetch orders for this customer
    $orders = \App\Models\Order::with('items')
                ->where('customer_id', $customer->customer_id)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('customer.accounts', compact('user', 'customer', 'orders'));
})->name('customer.accounts')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Customer Orders
|--------------------------------------------------------------------------
*/
Route::prefix('customer/orders')->middleware('auth')->group(function() {
    Route::get('/', [OrderController::class, 'index'])->name('customer.orders.index');
    Route::post('/cancel/{order}', [OrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/return/{order}', [OrderController::class, 'return'])->name('customer.orders.return');
});
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/orders/{order}/review', [OrderController::class, 'feedbackForm'])
     ->name('customer.reviews')
     ->middleware('auth');

Route::post('/orders/{order}/review', [OrderController::class, 'submitFeedback'])
     ->name('customer.submitFeedback')
     ->middleware('auth');
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

use App\Http\Controllers\SslCommerzPaymentController;
// routes/web.php
use App\Http\Controllers\CustomerServiceController;

Route::get('/customer-service', [CustomerServiceController::class, 'showform'])->name('customer.service.form');
Route::post('/customer-service', [CustomerServiceController::class, 'submitTicket'])->name('customer.service.submit');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])
        ->name('admin.reviews.index');
    Route::get('support-issues', [\App\Http\Controllers\Admin\SupportController::class, 'index'])
        ->name('admin.support.issues');
    Route::post('reviews/{review}/update-status', [\App\Http\Controllers\Admin\SupportController::class, 'updateStatus'])
    ->name('admin.reviews.updateStatus');
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'adminindex'])
        ->name('admin.orders.index');
    Route::post('orders/{order}/update-status', [App\Http\Controllers\OrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
    
});

// SSLCOMMERZ Start
Route::get('checkout1', [SslCommerzPaymentController::class, 'exampleEasyCheckout'])
    ->name('checkout1');
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

// admin/cateories routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])
        ->name('admin.categories.index');

    Route::get('categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])
        ->name('admin.categories.create');

    Route::post('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])
        ->name('admin.categories.store');

    Route::get('categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])
        ->name('admin.categories.edit');

    Route::put('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])
        ->name('admin.categories.update');

    Route::delete('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])
        ->name('admin.categories.destroy');

});

Route::prefix('admin')->name('admin.')->group(function () {

    // Show products in a category
    Route::get('categories/{category}/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])
        ->name('products.index');

    // Create product form
    Route::get('categories/{category}/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])
        ->name('products.create');

    // Store new product
    Route::post('categories/{category}/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])
        ->name('products.store');

    // Edit product
    Route::get('products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])
        ->name('products.edit');

    // Update product
    Route::put('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])
        ->name('products.update');

    // Delete product
    Route::delete('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])
        ->name('products.destroy');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
});
