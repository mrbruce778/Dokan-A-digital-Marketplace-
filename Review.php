<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'review_id';
    public $timestamps = false;

    protected $fillable = [
        'rating',
        'review_text',
        'review_date',
        'product_id',
        'customer_id',
    ];

    // Relation to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Relation to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
