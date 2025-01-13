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
        Schema::create('tukuran', function (Blueprint $table) {
            $table->bigincrements('id_ukuran');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_kategori');
            $table->string('ukuran', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tukuran');
    }
};
