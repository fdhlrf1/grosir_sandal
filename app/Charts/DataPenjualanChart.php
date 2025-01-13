<?php

namespace App\Charts;

use App\Models\Penjualan;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class DataPenjualanChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $id_toko = session('id_toko');
        // Ambil data penjualan yang dikelompokkan berdasarkan bulan
        $salesData = Penjualan::selectRaw('MONTH(tanggal_pembayaran) as month, YEAR(tanggal_pembayaran) as year, SUM(total) as total_sales')
            ->where('id_toko', $id_toko)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Siapkan data untuk grafik
        $months = [];
        $total_sales = [];

        foreach ($salesData as $sale) {
            $months[] = date('F Y', mktime(0, 0, 0, $sale->month, 1, $sale->year)); // Format bulan dan tahun
            $total_sales[] = $sale->total_sales;
        }

        // Buat grafik batang dengan data yang diambil
        return $this->chart->barChart() // Ganti lineChart() dengan barChart()
            ->setTitle('Total Pendapatan per Bulan')
            ->setSubtitle('Data Pendapatan Bulanan')
            ->addData('Pendapatan', $total_sales)
            ->setLabels($months);
    }
}