<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'tpenjualan'; // Nama tabel

    protected $primaryKey = 'nopenjualan'; // Primary key

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    protected $fillable = [
        'nopenjualan',
        'id_konsumen',
        'id_user',
        'id_toko',
        'total',
        'bayar',
        'kembalian',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'status',
        'dp',
        'sisa',
        'tanggal_jatuh_tempo',
        'tanggal_lunas',
        'jumlah_pelunasan',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    // Relasi ke DetailPenjualan
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'nopenjualan', 'nopenjualan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke Konsumen (jika ada)
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }
}
