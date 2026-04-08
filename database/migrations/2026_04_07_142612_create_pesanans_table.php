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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('idpesanan');
            $table->string('nama'); // Nama customer otomatis (Guest_xxx)
            $table->integer('total');
            $table->string('metode_bayar')->nullable();
            $table->string('status_bayar'); // 'Belum Bayar' atau 'Lunas'
            $table->string('snap_token')->nullable(); // Penting untuk Midtrans
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
