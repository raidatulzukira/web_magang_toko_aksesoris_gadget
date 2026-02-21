<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($order_number)
    {
        // Cari pesanan berdasarkan nomor order, dan pastikan itu milik user yang sedang login
        $order = Order::with('items.product')
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('customer.order_detail', compact('order'));
    }
}
