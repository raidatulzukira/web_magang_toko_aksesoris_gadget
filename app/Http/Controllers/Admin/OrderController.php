<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Menampilkan semua pesanan di tabel Admin
    public function index()
    {
        // Ambil semua pesanan dari yang paling baru, beserta data user-nya
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // 2. Menampilkan detail satu pesanan
    public function show($id)
    {
        // Ambil pesanan beserta data user dan barang yang dibeli
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Menyimpan perubahan status dari Admin
    public function update(Request $request, $id)
    {
        // Validasi inputan status
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,completed',
            'payment_status' => 'required|in:unpaid,paid,cancelled'
        ]);

        // Cari pesanan dan update statusnya
        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status
        ]);

        // Kembalikan ke halaman daftar pesanan dengan pesan sukses
        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
