<?php

namespace App\Charts;

use App\Models\Barang;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DataBarangChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    protected $chartbarang;

    public function __construct(LarapexChart $chartbarang)
    {
        $this->chartbarang = $chartbarang;
    }


    public function build()
    {
        // Mengambil data kategori barang dan menghitung jumlah barang per kategori
        $kategoriData = Barang::with(['kategori', 'satuan'])
            ->select('id_kategori', 'stok', 'id_satuan')
            ->get();

        // Mendapatkan nama kategori dan jumlahnya
        $kategoriStok = [];

        foreach ($kategoriData as $data) {
            $kategori = $data->kategori->nama;
            $satuan = $data->satuan ? $data->satuan->nama_satuan : 'Tidak Diketahui'; // Nama satuan, misal "kodi" atau "pcs"

            // Konversi stok berdasarkan satuan
            $stok = $data->stok;
            // dd($stok);
            if ($satuan === 'Kodi') {
                // Jika satuan adalah kodi, tidak perlu konversi
                $stok /= 20; // Stok tetap
                // dd($stok);
            } elseif ($satuan === 'Pcs') {
                // Jika satuan adalah pcs, konversi ke kodi
                $stok /= 20; // 1 kodi = 20 pcs

            } else {
                // Untuk satuan lain, anggap stoknya tetap dan beri keterangan jika perlu
                // Misalnya jika ada satuan lain yang tidak dikenali
                continue; // Lewati iterasi ini jika satuan tidak dikenali
            }

            // Menambahkan stok ke kategori
            if (!isset($kategoriStok[$kategori])) {
                $kategoriStok[$kategori] = [
                    'total' => 0,
                    'satuan' => 'Kodi' // Satuan yang digunakan dalam chart
                ];
            }
            $kategoriStok[$kategori]['total'] += $stok; // Jumlahkan stok per kategori
        }

        // Membuat array untuk sumbu X dan Y
        $categories = array_keys($kategoriStok);
        $totals = [];

        // Gabungkan total stok dengan nama satuan untuk ditampilkan
        foreach ($categories as $kategori) {
            $totalStok = $kategoriStok[$kategori]['total'];
            $totals[] = "Jumlah Barang: {$totalStok} Kodi"; // Format: "Jumlah Barang: x Kodi"
        }


        // dd($totals); // Debug untuk memeriksa hasil

        // Membuat chart tipe bar untuk menampilkan data kategori barang
        return $this->chartbarang->barChart()
            ->setTitle('Kategori Barang di Toko')
            ->setSubtitle('Distribusi Barang Berdasarkan Kategori')
            ->addData('Jumlah Barang', $totals)  // Data total stok dengan satuan
            ->setXAxis($categories); // Label kategori pada sumbu X
    }
}
