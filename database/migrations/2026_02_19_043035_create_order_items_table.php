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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel Order dan Product
            // onDelete('cascade') artinya jika order dihapus, item ini ikut terhapus
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity');      // Jumlah beli
            $table->decimal('price', 15, 2);  // Harga satuan saat dibeli

            // KOLOM PENTING:
            // Menyimpan tipe HP yang dipilih pembeli (Contoh: "iPhone 11")
            // Jika barang universal, ini akan null.
            $table->string('variant_info')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
