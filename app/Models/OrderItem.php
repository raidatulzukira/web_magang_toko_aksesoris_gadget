<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Sesuai dengan kolom di database milikmu
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_info', // Di DB kamu namanya variant_info
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
