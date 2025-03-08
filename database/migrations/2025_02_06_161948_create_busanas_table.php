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
        Schema::create('busanas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama busana
            $table->text('deskripsi')->nullable(); // Deskripsi busana
            $table->decimal('harga_sewa', 10, 2); // Harga sewa busana per hari
            $table->string('gambar')->nullable(); // Gambar busana (opsional)
            $table->integer('stok'); // Stok busana yang tersedia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busanas');
    }
};
