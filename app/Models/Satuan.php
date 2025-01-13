<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'tsatuan';
    protected $fillable = [
        'id_user',
        'id_toko',
        'nama_satuan',
        'konversi',
    ];

    protected $primaryKey = 'id_satuan';

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
        return $this->hasMany(Barang::class, 'id_satuan', 'id_satuan');
    }
}
