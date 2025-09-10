<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;

    protected $table = 'productgallery';   // Your table name (not plural 'galleries')

    protected $primaryKey = 'gallery_id'; // Primary key column
    public $incrementing = true;         // Auto increment
    protected $keyType = 'int';          // Primary key type

    public $timestamps = false;          // No created_at / updated_at columns

    protected $fillable = [
        'image_url',
        'alt_text',
        'product_id',
    ];

    /**
     * Relationship: Gallery belongs to a Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
