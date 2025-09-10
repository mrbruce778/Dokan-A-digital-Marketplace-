<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';
    public $timestamps = true;

    protected $fillable = ['customer_id', 'status']; // Remove 'price_at_purchase'

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }
}