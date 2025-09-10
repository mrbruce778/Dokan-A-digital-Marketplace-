<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        // Make categories available in all views
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });

        // Make cart count available in all views
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cart = Cart::where('customer_id', Auth::user()->customer_id)
                            ->where('status', 'active')
                            ->withCount('items')
                            ->first();
                $cartCount = $cart ? $cart->items_count : 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
