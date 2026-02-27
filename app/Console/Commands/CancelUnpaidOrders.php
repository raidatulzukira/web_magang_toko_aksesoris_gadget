<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CancelUnpaidOrders extends Command
{
    // Nama perintah yang nanti dipanggil
    protected $signature = 'orders:cancel-unpaid';

    // Deskripsi perintah
    protected $description = 'Membatalkan pesanan yang belum dibayar lebih dari 24 jam';

    public function handle()
    {
        // 1. Tentukan batas waktu (Misal: 24 jam yang lalu)
        $timeLimit = Carbon::now()->subMinutes(3);

        // 2. Cari order yang 'unpaid'/'pending' DAN dibuat sebelum batas waktu
        $expiredOrders = Order::whereIn('payment_status', ['unpaid', 'pending'])
                              ->where('order_status', '!=', 'cancelled')
                              ->where('created_at', '<', $timeLimit)
                              ->where('address', 'not like', '%Metode: COD%')
                              ->get();

        if ($expiredOrders->count() > 0) {
            foreach ($expiredOrders as $order) {
                // A. Ubah Status jadi Cancelled
                $order->update([
                    'order_status' => 'cancelled',
                    'payment_status' => 'cancelled'
                ]);

                // B. Kembalikan Stok Barang
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }

                $this->info("Order {$order->order_number} telah dibatalkan otomatis.");
            }
        } else {
            $this->info('idak ada pesanan transfer kadaluarsa.');
        }
    }
}
