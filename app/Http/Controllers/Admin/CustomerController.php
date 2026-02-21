<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Menampilkan daftar semua pelanggan yang pernah belanja
    public function index()
    {
        // Ambil user yang punya pesanan, hitung jumlah pesanannya, dan jumlahkan total belanjanya
        $customers = User::whereHas('orders')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->orderByDesc('orders_count') // Urutkan dari yang paling sering belanja
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    // 2. Menampilkan profil detail dan riwayat belanja 1 pelanggan
    public function show($id)
    {
        // Ambil data user beserta seluruh riwayat pesanannya
        $customer = User::with(['orders' => function($query) {
            $query->latest();
        }, 'orders.items.product'])->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }
}
