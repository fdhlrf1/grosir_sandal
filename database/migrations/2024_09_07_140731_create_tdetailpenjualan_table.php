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
        Schema::create('tdetailpenjualan', function (Blueprint $table) {
            $table->bigIncrements('id_detail');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->string('nopenjualan', 50);
            $table->unsignedBigInteger('id_satuan');
            $table->string('kd_barang', 50);
            //$table->string('nama', 50);
            //$table->string('warna', 50);
            $table->integer('h_beli')->nullable();
            $table->integer('h_jual');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tdetailpenjualan');
    }
};
