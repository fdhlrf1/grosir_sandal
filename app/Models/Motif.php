<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    use HasFactory;
    protected $table = 'tmotif';
    protected $fillable = [
        'id_user',
        'id_toko',
        'id_kategori',
        'nama_motif',
    ];

    protected $primaryKey = 'id_motif';

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke model Barang (hasMany)
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_motif', 'id_motif');
    }
}
