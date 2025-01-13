<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'tbarang';
    protected $fillable = [
        'kd_barang',
        'id_pemasok',
        'id_satuan',
        'id_kategori',
        'id_motif',
        'id_user',
        'id_toko',
        'h_beli',
        'h_jual',
        'stok',
        'warna',
        'size',
        'gambar'

    ];
    public $timestamps = false;

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi dengan model Pemasok
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok', 'id_pemasok');
    }

    // Relasi dengan model Satuan
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    // Relasi dengan model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function motif()
    {
        return $this->belongsTo(Motif::class, 'id_motif', 'id_motif');
    }
}
