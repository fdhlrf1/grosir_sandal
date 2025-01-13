<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Charts\DataBarangChart;
use App\Charts\DataPenjualanChart;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index(DataPenjualanChart $chart, DataBarangChart $chatbarang)
    {
        $id_toko = session('id_toko');

        // BAGIAN DASHBOARD ADMIN
        // $datapenjualan = Penjualan::where('id_toko', $id_toko)->count();
        // $totalnilaipenjualan = Penjualan::where('id_toko', $id_toko)->sum('total');
        // $totalnilaipembelian = Pembelian::where('id_toko', $id_toko)->sum('total');
        $now = Carbon::now();
        // PEMBELIAN
        $tPembelianBulanIni = Pembelian::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembelian', $now->year)
            ->whereMonth('tanggal_pembelian', $now->month)
            ->sum('total');
        // dd($tPembelianBulanIni);
        $tPembelianBulanLalu = Pembelian::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembelian', $now->copy()->subMonth()->year)
            ->whereMonth('tanggal_pembelian', $now->copy()->subMonth()->month)
            ->sum('total');
        // dd($tPembelianBulanLalu);
        $persentaseKenaikanPembelian = $tPembelianBulanLalu > 0
            ? (($tPembelianBulanIni - $tPembelianBulanLalu) / $tPembelianBulanLalu) * 100
            : 0;

        // PENJUALAN
        $tPenjualanBulanIni = Penjualan::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembayaran', $now->year)
            ->whereMonth('tanggal_pembayaran', $now->month)
            ->sum('total');
        $tDataPenjualanBulanIni = Penjualan::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembayaran', $now->year)
            ->whereMonth('tanggal_pembayaran', $now->month)
            ->count();
        // dd($tPenjualanBulanIni);
        $tPenjualanBulanLalu = Penjualan::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembayaran', $now->copy()->subMonth()->year)
            ->whereMonth('tanggal_pembayaran', $now->copy()->subMonth()->month)
            ->count();
        // dd($tPenjualanBulanLalu);
        $persentaseKenaikanPenjualan = $tPenjualanBulanLalu > 0
            ? (($tDataPenjualanBulanIni - $tPenjualanBulanLalu) / $tPenjualanBulanLalu) * 100
            : 0;

        // PENDAPATAN
        $tPendapatanBulanIni = Penjualan::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembayaran', $now->year)
            ->whereMonth('tanggal_pembayaran', $now->month)
            ->sum('total');
        // dd($tPendapatanBulanIni);
        $tPendapatanBulanLalu = Penjualan::where('id_toko', $id_toko)
            ->whereYear('tanggal_pembayaran', $now->copy()->subMonth()->year)
            ->whereMonth('tanggal_pembayaran', $now->copy()->subMonth()->month)
            ->sum('total');
        // dd($tPendapatanBulanLalu);
        $persentaseKenaikanPendapatan = $tPendapatanBulanLalu > 0
            ? (($tPendapatanBulanIni - $tPendapatanBulanLalu) / $tPendapatanBulanLalu) * 100
            : 0;

        //BAGIAN ADMIN KASIR
        $kreditAktif = Penjualan::with('konsumen')
            ->where('id_toko', $id_toko)
            ->where('status', 'Belum Lunas')
            ->get(['nopenjualan', 'total', 'dp', 'sisa', 'tanggal_jatuh_tempo', 'id_konsumen']);
        $tPendapatanHariIni = Penjualan::where('id_toko', $id_toko)
            ->whereDate('tanggal_pembayaran', $now->toDateString())
            ->sum('total');
        $tTransaksiHariIni = Penjualan::where('id_toko', $id_toko)
            ->whereDate('tanggal_pembayaran', $now->toDateString())
            ->count();
        $tBarangTerjual = DB::table('tdetailpenjualan')
            ->join('tpenjualan', 'tdetailpenjualan.nopenjualan', '=', 'tpenjualan.nopenjualan')
            ->where('tpenjualan.id_toko', $id_toko)
            ->whereDate('tpenjualan.tanggal_pembayaran', $now->toDateString())
            ->sum('tdetailpenjualan.qty');

        $transaksiTerbaru = Penjualan::where('id_toko', $id_toko)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->take(3)
            ->get();
        // dd($transaksiTerbaru);
        // dd([
        //     'pendapatan' => $tPendapatanHariIni,
        //     'transaksi' => $tTransaksiHariIni,
        //     'barang' => $tBarangTerjual,
        // ]);
        return view('beranda', [
            'tDataPenjualanBulanIni' => $tDataPenjualanBulanIni,
            'tPenjualanBulanIni' => $tPenjualanBulanIni,
            'tPembelianBulanIni' => $tPembelianBulanIni,
            'transaksiTerbaru' => $transaksiTerbaru,
            'tPendapatanHariIni' => $tPendapatanHariIni,
            'tTransaksiHariIni' => $tTransaksiHariIni,
            'tBarangTerjual' => $tBarangTerjual,
            'kreditAktif' => $kreditAktif,
            // 'totalnilaipembelian' => $totalnilaipembelian,
            // 'datapenjualan' => $datapenjualan,
            // 'totalnilaipenjualan' => $totalnilaipenjualan,
            'title' => 'Beranda',
            'persentaseKenaikanPendapatan' => min(max(round($persentaseKenaikanPendapatan, 2), 0), 100),
            'persentaseKenaikanPenjualan' => min(max(round($persentaseKenaikanPenjualan, 2), 0), 100),
            'persentaseKenaikanPembelian' => min(max(round($persentaseKenaikanPembelian, 2), 0), 100),
            'chart' => $chart->build(),
            'chartbarang' => $chatbarang->build(),
        ]);
    }
}
