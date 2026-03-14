<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil SEMUA pesanan milik user yang sedang login dari yang terbaru
        $orders = Order::where('user_id', auth()->id())
                       ->with('items.product')
                       ->latest()
                       ->get();

        return view('customer.orders.index', compact('orders'));
    }

    public function show($order_number)
    {
        // Cari pesanan berdasarkan nomor order, dan pastikan itu milik user yang sedang login
        $order = Order::with('items.product')
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('customer.order_detail', compact('order'));
    }

    public function complete($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Pastikan statusnya memang sedang dikirim, tidak bisa curi start
        // if ($order->order_status !== 'shipped') {
        //     return redirect()->back()->with('error', 'Hanya pesanan yang sedang dikirim yang bisa diselesaikan.');
        // }
        if ($order->order_status !== 'delivered') {
            return redirect()->back()->with('error', 'Tombol konfirmasi hanya aktif setelah Admin memverifikasi paket telah tiba.');
        }

        // Ubah status jadi selesai dan lunas (Penting untuk sistem COD)
        $order->update([
            'order_status' => 'completed',
            'payment_status' => 'paid',
        ]);

        return redirect()->back()->with('success', 'Hore! Pesanan berhasil diselesaikan. Terima kasih telah berbelanja!');
    }
}
