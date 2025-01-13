<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'tdetailpembelian'; // Nama tabel



    protected $fillable = [
        'id_user',
        'id_toko',
        'nopembelian',
        'id_satuan',
        'kd_barang',
        'h_beli',
        'qty',
        'subtotal',
        // Tambahkan kolom lain yang diperlukan
    ];
    public $timestamps = true;

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
    // Relasi ke Pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'nopembelian', 'nopembelian');
    }

    // Relasi ke Satuan
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kd_barang', 'kd_barang');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
