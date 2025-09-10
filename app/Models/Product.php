<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductGallery;
class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'price', 'category_id','status'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'product_id');
    }
}
