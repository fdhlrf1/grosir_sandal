<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'nama_toko',
        'password',
        'role_id',
        'toko_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function kategori()
    {
        return $this->hasMany(Kategori::class, 'id_user', 'id');
    }

    public function pemasok()
    {
        return $this->hasMany(Pemasok::class, 'id_user', 'id');
    }

    public function satuan()
    {
        return $this->hasMany(Satuan::class, 'id_user', 'id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_user', 'id');
    }

    public function detailpenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_user', 'id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_user', 'id');
    }

    public function detailpembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_user', 'id');
    }

    public function konsumen()
    {
        return $this->hasMany(Konsumen::class, 'id_user', 'id');
    }

    // Definisi relasi one-to-many ke Barang
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_user', 'id');
    }

    public function motif()
    {
        return $this->hasMany(Motif::class, 'id_user', 'id');
    }

    public function warna()
    {
        return $this->hasMany(Warna::class, 'id_user', 'id');
    }

    public function ukuran()
    {
        return $this->hasMany(Ukuran::class, 'id_user', 'id');
    }
}
