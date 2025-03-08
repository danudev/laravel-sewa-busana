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
        Schema::table('transaksis', function (Blueprint $table) {
            // Mengubah status menjadi enum dengan dua nilai saja
            $table->enum('status', ['dipinjam', 'selesai'])->default('dipinjam')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Rollback perubahan jika migrasi di-revert
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);
            $table->enum('status', ['pending', 'proses', 'selesai', 'batal'])->default('pending')->change();
        });
    }
};
