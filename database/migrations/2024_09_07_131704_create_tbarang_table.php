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
        Schema::create('tbarang', function (Blueprint $table) {
            $table->id();
            $table->string('kd_barang', '40')->unique();
            $table->unsignedBigInteger('id_pemasok');
            $table->unsignedBigInteger('id_satuan');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_motif');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->integer('h_beli');
            $table->integer('h_jual');
            $table->unsignedBigInteger('stok');
            $table->string('warna', 50);
            $table->string('size', 50);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbarang');
    }
};
