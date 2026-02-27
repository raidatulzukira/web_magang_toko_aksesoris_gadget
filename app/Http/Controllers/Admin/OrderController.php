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
    // 3. Menyimpan perubahan status dari Admin
    // public function update(Request $request, $id)
    // {
    //     // Validasi inputan status (Tambahkan 'cancelled' di order_status)
    //     $request->validate([
    //         'order_status' => 'required|in:processing,shipped,completed,cancelled',
    //         'payment_status' => 'required|in:unpaid,paid,cancelled'
    //     ]);

    //     $order = Order::findOrFail($id);

    //     // LOGIKA 1: Jika pesanan sudah LUNAS dan SELESAI, jangan biarkan dibatalkan
    //     if ($order->payment_status == 'paid' && ($request->order_status == 'cancelled' || $request->payment_status == 'cancelled')) {
    //         return redirect()->back()->with('error', 'Pesanan yang sudah Lunas tidak dapat dibatalkan!');
    //     }

    //     // LOGIKA 2: Jika salah satu status di-set ke Batal, maka batalkan KEDUANYA
    //     if ($request->order_status == 'cancelled' || $request->payment_status == 'cancelled') {
    //         $order->update([
    //             'order_status' => 'cancelled',
    //             'payment_status' => 'cancelled'
    //         ]);

    //         // Kembalikan stok barang karena pesanan batal
    //         foreach ($order->items as $item) {
    //             $item->product->increment('stock', $item->quantity);
    //         }

    //         return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
    //     }

    //     // Jika normal (update status dari diproses -> dikirim -> selesai)
    //     $order->update([
    //         'order_status' => $request->order_status,
    //         'payment_status' => $request->payment_status
    //     ]);

    //     return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    // }

    // 3. Menyimpan perubahan status dari Admin
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'order_status' => 'required|in:processing,shipped,completed,cancelled',
    //     ]);

    //     $order = Order::findOrFail($id);
    //     $newPaymentStatus = $request->payment_status; // Ambil status awal dari hidden input

    //     // LOGIKA 1: Jika pesanan sudah LUNAS dan SELESAI, tidak bisa dibatalkan
    //     if ($order->payment_status == 'paid' && $request->order_status == 'cancelled') {
    //         return redirect()->back()->with('error', 'Pesanan yang sudah Lunas tidak dapat dibatalkan!');
    //     }

    //     // LOGIKA 2: Jika Admin klik DIBATALKAN -> Batalkan Keduanya & Kembalikan Stok
    //     if ($request->order_status == 'cancelled') {
    //         $order->update([
    //             'order_status' => 'cancelled',
    //             'payment_status' => 'cancelled' // Otomatis ubah pembayaran jadi batal
    //         ]);

    //         // Kembalikan stok barang
    //         foreach ($order->items as $item) {
    //             $item->product->increment('stock', $item->quantity);
    //         }

    //         return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
    //     }

    //     // LOGIKA 3: Jika Admin klik SELESAI -> Otomatis LUNASKAN pembayarannya (Berguna untuk sistem COD)
    //     if ($request->order_status == 'completed') {
    //         $newPaymentStatus = 'paid';
    //     }

    //     // Jika normal (update status dari diproses -> dikirim -> selesai)
    //     $order->update([
    //         'order_status' => $request->order_status,
    //         'payment_status' => $newPaymentStatus
    //     ]);

    //     return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    // }

    public function update(Request $request, $id)
    {
        // Validasi: Tambahkan 'pending' lagi ke dalam daftar yang dibolehkan
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $newPaymentStatus = $request->payment_status;

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

        // Simpan
        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $newPaymentStatus
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
