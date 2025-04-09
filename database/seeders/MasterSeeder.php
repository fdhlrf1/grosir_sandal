<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Konsumen;
use App\Models\Motif;
use App\Models\Pemasok;
use App\Models\Satuan;
use App\Models\Ukuran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Pemasok::truncate();
        Konsumen::truncate();
        Satuan::truncate();
        Kategori::truncate();
        Motif::truncate();
        Ukuran::truncate();
        Schema::enableForeignKeyConstraints();

        // Insert pemasok
        Pemasok::create([
            'id_user' => 1,
            'id_toko' => 1,
            'nama' => 'Andi',
            'alamat' => 'Bandung',
            'telepon' => '08978783283',
        ]);

        // Insert konsumen
        Konsumen::create([
            'id_user' => 1,
            'id_toko' => 1,
            'nama' => 'Rudi',
            'alamat' => 'Cicalengka',
            'telepon' => '08888888888',
        ]);

        // Insert satuan
        Satuan::create([
            'id_user' => 1,
            'id_toko' => 1,
            'nama_satuan' => 'Kodi',
            'konversi' => 20,
        ]);

        // Insert kategori
        Kategori::create([
            'id_user' => 1,
            'id_toko' => 1,
            'nama' => 'Sandal Anak Cowo',
            'deskripsi' => 'Sandal Anak Cowo berbahan kualitas tinggi',
        ]);

        // Insert motif
        Motif::create([
            'id_user' => 1,
            'id_toko' => 1,
            'id_kategori' => 1,
            'nama_motif' => 'Pulkadot',
        ]);

        // Insert ukuran
        Ukuran::create([
            'id_user' => 1,
            'id_toko' => 1,
            'id_kategori' => 1,
            'ukuran' => '36-42',
        ]);
    }
}
