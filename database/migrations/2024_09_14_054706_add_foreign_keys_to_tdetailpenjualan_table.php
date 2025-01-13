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
        Schema::table('tdetailpenjualan', function (Blueprint $table) {
            //
            $table->foreign('nopenjualan')->references('nopenjualan')->on('tpenjualan')->onDelete('cascade');
            $table->foreign('kd_barang')->references('kd_barang')->on('tbarang')->onDelete('cascade');
            $table->foreign('id_satuan')->references('id_satuan')->on('tsatuan')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_toko')->references('id')->on('toko')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tdetailpenjualan', function (Blueprint $table) {
            //
        });
    }
};