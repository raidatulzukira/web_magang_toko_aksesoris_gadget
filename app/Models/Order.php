<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Sesuai dengan kolom di database milikmu
    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'payment_status',
        'order_status',
        'courier',
        'tracking_number',
        'snap_token',
        'address',
        'phone'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
