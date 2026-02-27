<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menyimpan ID Admin yang mengubah role
            $table->foreignId('role_changed_by')->nullable()->constrained('users')->nullOnDelete();
            // Menyimpan kapan role itu diubah
            $table->timestamp('role_changed_at')->nullable();
            // Menyimpan role lamanya apa (sebelum diubah)
            $table->string('previous_role')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_changed_by']);
            $table->dropColumn(['role_changed_by', 'role_changed_at', 'previous_role']);
        });
    }
};
