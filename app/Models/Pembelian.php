<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'tpembelian'; // Nama tabel


    protected $fillable = [
        'nopembelian',
        'id_pemasok',
        'id_user',
        'id_toko',
        'total',
        'tanggal_pembelian',
        // 'bayar',
        // 'kembalian',
        // 'metode_pembayaran',
        // 'status',
        // 'dp',
        // 'tanggal_lunas',
        // 'jumlah_pelunasan',

        // Tambahkan kolom lain yang diperlukan
    ];

    public $timestamps = true;
    protected $primaryKey = 'nopembelian';


    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
    // Relasi ke Pemasok
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok', 'id_pemasok');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Jika ada relasi ke DetailPembelian
    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'nopembelian', 'nopembelian'); // Pastikan untuk menyesuaikan dengan nama kolom yang benar
    }
}
