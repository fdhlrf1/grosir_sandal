<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table = 'toko';
    protected $fillable = [
        'nama_toko',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
