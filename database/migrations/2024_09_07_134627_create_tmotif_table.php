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
        Schema::create('tmotif', function (Blueprint $table) {
            $table->bigincrements('id_motif');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_motif', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmotif');
    }
};
