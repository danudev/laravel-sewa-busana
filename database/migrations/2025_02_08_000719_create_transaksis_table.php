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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // ID transaksi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke pengguna (user)
            $table->foreignId('busana_id')->constrained('busanas')->onDelete('cascade'); // Relasi ke busana yang disewa
            $table->decimal('total_harga', 10, 2); // Total harga sewa
            $table->timestamp('tanggal_mulai'); // Tanggal mulai penyewaan
            $table->timestamp('tanggal_selesai'); // Tanggal selesai penyewaan
            $table->timestamp('tanggal_pengembalian')->nullable(); // Tanggal pengembalian busana
            $table->decimal('denda', 10, 2)->default(0); // Denda keterlambatan
            $table->enum('status', ['pending', 'proses', 'selesai', 'batal'])->default('pending'); // Status transaksi
            $table->timestamps(); // Waktu pembuatan dan update transaksi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
