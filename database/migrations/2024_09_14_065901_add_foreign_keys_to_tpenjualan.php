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
        Schema::table('tpenjualan', function (Blueprint $table) {
            //
            $table->foreign('id_konsumen')->references('id_konsumen')->on('tkonsumen')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_toko')->references('id')->on('toko')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tpenjualan', function (Blueprint $table) {
            //
            $table->dropForeign(['id_konsumen']);
        });
    }
};
