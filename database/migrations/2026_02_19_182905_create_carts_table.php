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
        Schema::create('carts', function (Blueprint $table) {
        $table->id();
        // Relasi ke user (siapa yang punya keranjang)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // Relasi ke produk (barang apa yang dimasukkan)
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        // Menyimpan varian yang dipilih (opsional)
        $table->string('variant')->nullable();
        // Jumlah barang
        $table->integer('quantity')->default(1);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
