<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\OrderItem;

class Order extends Model
{
    protected $table = 'customerorder';
    protected $primaryKey = 'order_id';
    public $timestamps = true;

    protected $fillable = [
        'total_amount',
        'payment_method',
        'progress_status',
        'customer_id',
        'cart_id',
        'address',
        'phone_number',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
