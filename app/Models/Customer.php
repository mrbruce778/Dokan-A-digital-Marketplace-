<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'guest_flag',
    ];

    protected $hidden = [
        'password_hash',
    ];

    // Accessor for password to use with Laravel authentication
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Relation: Customer has many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id', 'customer_id');
    }

    // Relation: Customer has many orders (if you have Order model)
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
