<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'variant', 'quantity'];

    // Keranjang ini milik 1 Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Keranjang ini milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
