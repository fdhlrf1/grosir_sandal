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
        Schema::create('tpenjualan', function (Blueprint $table) {
            $table->string('nopenjualan')->primary();
            $table->unsignedBigInteger('id_konsumen');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            //$table->unsignedBigInteger('id_sales');
            $table->integer('total');
            $table->integer('bayar');
            $table->integer('kembalian');
            $table->dateTime('tanggal_pembayaran');
            $table->string('metode_pembayaran', 50);
            $table->string('status', 50);
            $table->integer('dp')->nullable();
            $table->integer('sisa')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_lunas')->nullable();
            $table->integer('jumlah_pelunasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpenjualan');
    }
};
