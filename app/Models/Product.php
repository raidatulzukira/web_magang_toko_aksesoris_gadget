<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // INI YANG WAJIB DITAMBAHKAN
    // Mendaftarkan kolom apa saja yang boleh diisi dari form
    protected $fillable = [
        'name',
        'price',
        'stock',
        'variants',
        'description',
        'image',
    ];
}
