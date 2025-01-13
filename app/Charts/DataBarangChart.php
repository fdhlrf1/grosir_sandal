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
        $id_toko = session('id_toko');
        // Mengambil data kategori barang dan menghitung jumlah barang per kategori
        $kategoriData = Barang::with(['kategori', 'satuan'])
            ->where('id_toko', $id_toko) // Filter berdasarkan id_toko
            ->select('id_kategori', 'stok', 'id_satuan')
            ->get();

        // dd($kategoriData);
        // Mendapatkan nama kategori dan jumlahnya
        $kategoriStok = [];

        foreach ($kategoriData as $data) {
            $kategori = $data->kategori->nama;
            $satuan = $data->satuan->nama_satuan; // Nama satuan, misal "kodi" atau "pcs"
            // dd($satuan);
            // Konversi stok berdasarkan satuan
            $stok = $data->stok;
            // dd($stok);
            if ($satuan === 'Kodi' || $satuan === 'Pcs') {
                $stok /= 20;
            }

            if (!isset($kategoriStok[$kategori])) {
                $kategoriStok[$kategori] = [
                    'total' => 0,
                    'satuan' => $satuan // Simpan satuan yang sesuai untuk kategori ini
                ];
            }
            $kategoriStok[$kategori]['total'] += $stok; // Jumlahkan stok per kategori

            // dd($kategoriStok);
        }

        // Membuat array untuk sumbu X dan Y
        $categories = array_keys($kategoriStok);
        $totals = [];

        // dd($totals);

        // Gabungkan total stok dengan nama satuan untuk ditampilkan
        foreach ($categories as $kategori) {
            $satuan = $kategoriStok[$kategori]['satuan']; // Ambil nama satuan dari kategori
            $totals[] = "{$kategoriStok[$kategori]['total']} {$satuan}"; // Contoh: "40 pcs" atau "80 kodi"
        }

        // dd($totals);

        // Membuat chart tipe pie untuk menampilkan data kategori barang
        return $this->chartbarang->barChart()
            ->setTitle('Kategori Barang di Toko')
            ->setSubtitle('Distribusi Barang Berdasarkan Kategori')
            ->addData('Jumlah Barang Per Kodi', $totals)  // Label data untuk sumbu Y
            ->setXAxis($categories); // Label kategori pada sumbu X
    }
}
