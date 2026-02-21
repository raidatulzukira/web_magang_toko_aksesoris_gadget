<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Pembeli)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Nomor pesanan unik (Contoh: TRX-0001)
            $table->string('order_number')->unique();

            // Total harga belanjaan
            $table->decimal('total_price', 15, 2);

            // STATUS PEMBAYARAN (Penting untuk Midtrans)
            // Kita pakai teks biar gampang dibaca di database:
            // 'unpaid' = Belum bayar
            // 'paid' = Sudah bayar (Settlement)
            // 'cancelled' = Batal/Gagal
            $table->enum('payment_status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');

            // Token Midtrans (Disimpan biar user bisa lanjut bayar nanti)
            $table->string('snap_token')->nullable();

            // Info Pengiriman sederhana
            $table->text('address'); // Alamat lengkap
            $table->string('phone'); // Nomor WA penerima

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
