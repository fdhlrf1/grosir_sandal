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
        Schema::create('tkategori', function (Blueprint $table) {
            $table->bigIncrements('id_kategori');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->string('nama', 100); // Nama kategori
            $table->text('deskripsi')->nullable(); // Deskripsi kategori (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tkategori');
    }
};