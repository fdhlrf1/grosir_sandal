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
        Schema::create('tsatuan', function (Blueprint $table) {
            $table->bigincrements('id_satuan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->string('nama_satuan', 20);
            $table->integer('konversi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsatuan');
    }
};
