<?php
// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    // Add this to allow mass assignment
    protected $fillable = ['category_name', 'image_url', 'parent_category_id'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
