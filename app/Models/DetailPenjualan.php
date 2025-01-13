<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'tdetailpenjualan'; // Nama tabel

    protected $fillable = [
        'id_user',
        'id_toko',
        'nopenjualan',
        'id_satuan',
        'kd_barang',
        'h_beli',
        'h_jual',
        'qty',
        'subtotal',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke Penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'nopenjualan', 'nopenjualan');
    }

    // Relasi ke Satuan (jika ada)
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    // Relasi ke Barang (jika ada)
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_barang', 'kd_barang');
    }
}
