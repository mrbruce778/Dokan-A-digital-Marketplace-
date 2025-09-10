<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    use HasFactory;

    // Specify the existing table name
    protected $table = 'customersupport';

    // Primary key column
    protected $primaryKey = 'ticket_id';

    // Enable timestamps if your table has created_at/updated_at
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'issue_subject',
        'issue_description',
        'status',
        'customer_id',
        'created_at'
    ];
    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'customer_id');
    }
}
