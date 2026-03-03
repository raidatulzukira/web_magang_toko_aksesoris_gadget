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
        Schema::table('stock_histories', function (Blueprint $table) {
            // Menambahkan kolom current_stock setelah quantity
            $table->integer('current_stock')->after('quantity')->default(0);
        });
    }

    public function down()
    {
        Schema::table('stock_histories', function (Blueprint $table) {
            $table->dropColumn('current_stock');
        });
    }
};
