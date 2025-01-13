<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;
    protected $table = 'tpemasok';
    protected $fillable = [
        'id_user',
        'id_toko',
        'nama',
        'alamat',
        'telepon',

    ];

    protected $primaryKey = 'id_pemasok';

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
        return $this->hasMany(Barang::class, 'id_pemasok', 'id_pemasok');
    }
}
