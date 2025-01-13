<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'tkategori';
    protected $fillable = [
        'id_user',
        'id_toko',
        'nama',
        'deskripsi',
    ];
    protected $primaryKey = 'id_kategori';

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }

    public function motif()
    {
        return $this->hasMany(Motif::class, 'id_kategori', 'id_kategori');
    }

    public function warna()
    {
        return $this->hasMany(Warna::class, 'id_kategori', 'id_kategori');
    }

    public function ukuran()
    {
        return $this->hasMany(Ukuran::class, 'id_kategori', 'id_kategori');
    }
}
