<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    use HasFactory;

    protected $table = 'customerreview'; // your table name
    protected $primaryKey = 'review_id';
    public $timestamps = false; // since you have review_date instead of created_at

    protected $fillable = [
        'rating',
        'review_text',
        'review_date',
        'product_id',
        'customer_id',
    ];

    // Relationship to product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relationship to customer (User model)
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }
}
