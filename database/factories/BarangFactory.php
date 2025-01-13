<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pemasok; // Pastikan ini sesuai dengan namespace dan nama model Pemasok Anda
use App\Models\Satuan;   // Pastikan ini sesuai dengan namespace dan nama model Satuan Anda
use App\Models\Kategori; // Pastikan ini sesuai dengan namespace dan nama model Kategori Anda

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kd_barang' => $this->faker->unique()->numerify('BRG###'), // Kode barang acak
            'id_pemasok' => Pemasok::inRandomOrder()->value('id_pemasok'), // Mengambil id_pemasok acak dari Pemasok
            'id_satuan' => Satuan::inRandomOrder()->value('id_satuan'),   // Mengambil id_satuan acak dari Satuan
            'id_kategori' => Kategori::inRandomOrder()->value('id_kategori'), // Mengambil id_kategori acak dari Kategori
            'nama' => $this->faker->words(2, true), // Nama produk acak, dua kata
            'h_beli' => $this->faker->numberBetween(10000, 50000), // Harga beli acak antara 10,000 dan 50,000
            'h_jual' => $this->faker->numberBetween(50000, 100000), // Harga jual acak antara 50,000 dan 100,000
            'stok' => $this->faker->numberBetween(1, 100), // Stok acak antara 1 hingga 100
            'warna' => $this->faker->colorName, // Warna acak
            'gambar' => $this->faker->imageUrl(640, 480, 'barangs', true, 'sandals'), // Gambar acak dari kategori 'barangs' dengan teks 'sandals'
        ];
    }
}
