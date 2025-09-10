<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    public $timestamps = true;

    protected $fillable = [
        'cart_id', 
        'product_id', 
        'quantity', 
        'price_at_purchase'  // Make sure this is here
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}