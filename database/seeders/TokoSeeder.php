<?php

namespace Database\Seeders;

use App\Models\Toko;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Toko::truncate();
        Schema::enableForeignKeyConstraints();

        $toko = [
            [
                'nama_toko' => 'New Spon',
            ],
            [
                'nama_toko' => 'New Spon 2',
            ],
        ];

        foreach ($toko as $value) {
            Toko::create([
                'nama_toko' => $value['nama_toko'],
            ]);
        }
    }
}
