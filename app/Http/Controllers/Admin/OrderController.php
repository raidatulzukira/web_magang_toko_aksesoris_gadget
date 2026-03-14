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

    // public function update(Request $request, $id)
    // {
    //     // Validasi: Tambahkan 'pending' lagi ke dalam daftar yang dibolehkan
    //     $request->validate([
    //         'order_status' => 'required|in:pending,processing,shipped,completed,cancelled',
    //     ]);

    //     $order = Order::findOrFail($id);
    //     $newPaymentStatus = $request->payment_status;

    //     // LOGIKA 1: Pesanan Lunas tidak boleh dibatalkan
    //     if ($order->payment_status == 'paid' && $request->order_status == 'cancelled') {
    //         return redirect()->back()->with('error', 'Pesanan yang sudah Lunas tidak dapat dibatalkan!');
    //     }

    //     // LOGIKA 2: Batalkan Keduanya & Kembalikan Stok
    //     if ($request->order_status == 'cancelled') {
    //         $order->update([
    //             'order_status' => 'cancelled',
    //             'payment_status' => 'cancelled'
    //         ]);

    //         foreach ($order->items as $item) {
    //             $item->product->increment('stock', $item->quantity);
    //         }

    //         return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
    //     }

    //     // LOGIKA 3: Jika Selesai -> Lunas
    //     if ($request->order_status == 'completed') {
    //         $newPaymentStatus = 'paid';
    //     }

    //     // Simpan
    //     $order->update([
    //         'order_status' => $request->order_status,
    //         'payment_status' => $newPaymentStatus
    //     ]);

    //     return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    // }

    public function update(Request $request, $id)
    {
        // Validasi ditambah dengan courier dan tracking_number (optional, hanya wajib jika status shipped)
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled',
            'courier' => 'nullable|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $order = Order::findOrFail($id);
        $newPaymentStatus = $request->payment_status;

        // Validasi Khusus: Jika diubah jadi 'shipped' (Dikirim), maka Wajib Isi Resi & Kurir!
        if ($request->order_status == 'shipped') {
            if (empty($request->courier) || empty($request->tracking_number)) {
                return redirect()->back()->with('error', 'Pilih Jasa Pengiriman dan masukkan Nomor Resi jika pesanan Sedang Dikirim!');
            }
        }

        // LOGIKA 1: Pesanan Lunas tidak boleh dibatalkan
        if ($order->payment_status == 'paid' && $request->order_status == 'cancelled') {
            return redirect()->back()->with('error', 'Pesanan yang sudah Lunas tidak dapat dibatalkan!');
        }

        // LOGIKA 2: Batalkan Keduanya & Kembalikan Stok
        if ($request->order_status == 'cancelled') {
            $order->update([
                'order_status' => 'cancelled',
                'payment_status' => 'cancelled'
            ]);

            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
        }

        // LOGIKA 3: Jika Selesai -> Lunas
        if ($request->order_status == 'completed') {
            $newPaymentStatus = 'paid';
        }

        // Simpan Perubahan Utama + Data Resi
        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $newPaymentStatus,
            'courier' => $request->courier,
            'tracking_number' => $request->tracking_number,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status dan informasi pengiriman pesanan berhasil diperbarui!');
    }
}
