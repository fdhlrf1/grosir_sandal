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
        Schema::create('tpemasok', function (Blueprint $table) {
            $table->bigIncrements('id_pemasok');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->string('nama', 50);
            $table->text('alamat');
            $table->string('telepon', 20);
            $table->timestamps();

            //$table->foreign('kd_barang')->references('kd_barang')->on('tbarang')->onDelete('cascade');  // Optional: Menghapus pemasok jika barang dihapus->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpemasok');
    }
};
