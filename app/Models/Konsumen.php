<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;
    protected $table = 'tkonsumen';
    protected $fillable = [
        'id_user',
        'id_toko',
        'nama',
        'alamat',
        'telepon',
    ];
    protected $primaryKey = 'id_konsumen';

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
