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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('stock')->default(0);

            // KOLOM PENTING:
            // Diisi teks dipisah koma jika ada pilihan tipe HP.
            // Dikosongkan (NULL) jika barang universal (Charger/TWS).
            $table->string('variants')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
