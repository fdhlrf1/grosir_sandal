<?php

namespace App\Http\Controllers\Laporan;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PenjualanExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenjualanController extends Controller
{
    //
    public function index(Request $request)
    {
        $id_toko = session('id_toko');
        $id_user = session('id_user');

        $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])->where('id_toko', $id_toko)->latest()->simplePaginate(5);

        return view('laporan.lappenjualan', [
            'title' => 'Laporan Penjualan',
            'penjualans' => $penjualans,
        ]);
    }


    public function filter(Request $request)
    {

        $start = $request->input('start');
        $end = $request->input('end');

        // Pastikan kedua tanggal tidak kosong
        if (empty($start) || empty($end)) {
            return redirect()->back()->with('errortanggal', 'Tanggal mulai dan tanggal akhir harus diisi');
        }

        $metode_pembayaran = $request->input('metode_pembayaran');
        $status = $request->input('status');

        $startFormatted = Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d');
        $endFormatted = Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d');

        $id_toko = session('id_toko');

        $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
            ->where('id_toko', $id_toko)
            ->when($startFormatted && $endFormatted, function ($query) use ($startFormatted, $endFormatted) {
                // dd('star$startFormatted Date:', $startFormatted, 'end$endFormatted Date:', $endFormatted);
                return $query->whereRaw('DATE(tanggal_pembayaran) BETWEEN ? AND ?', [$startFormatted, $endFormatted]);
            })
            ->when($metode_pembayaran, function ($query) use ($metode_pembayaran) {
                return $query->where('metode_pembayaran', $metode_pembayaran);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->simplePaginate(10);

        return view('laporan.lappenjualan', [
            'title' => 'Laporan Penjualan',
            'penjualans' => $penjualans,
        ]);
    }


    public function showLaporanPenjualan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $metode_pembayaran = $request->input('metode_pembayaran');
        $status = $request->input('status');

        $id_toko = session('id_toko');

        if (empty($start) && empty($end) && empty($metode) && empty($status)) {
            $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
                ->where('id_toko', $id_toko)->get();

            $pendapatan = $penjualans->sum('total');
        } elseif (empty($start) || empty($end)) {
            return redirect()->back()->with('errortanggal', 'Tanggal mulai dan tanggal akhir harus diisi');
        } else {
            try {
                $startFormatted = Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d');
                $endFormatted = Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('errortanggal', 'Format tanggal tidak valid.');
            }
            // Query data penjualan dengan filter
            $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
                ->where('id_toko', $id_toko)
                ->when($startFormatted && $endFormatted, function ($query) use ($startFormatted, $endFormatted) {
                    return $query->whereRaw('DATE(tanggal_pembayaran) BETWEEN ? AND ?', [$startFormatted, $endFormatted]);
                })
                ->when($metode_pembayaran, function ($query) use ($metode_pembayaran) {
                    return $query->where('metode_pembayaran', $metode_pembayaran);
                })
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->orderBy('tanggal_pembayaran', 'desc')->get();

            $pendapatan = $penjualans->sum('total');
        }

        // Passing data ke view
        return view('laporan.cetak-lappenjualan.show-laporan-penjualan', [
            'title' => 'Show Laporan Penjualan',
            'penjualans' => $penjualans,
            'pendapatan' => $pendapatan,
            'start' => $start,
            'end' => $end,
            'metode_pembayaran' => $metode_pembayaran,
            'status' => $status,
        ]);
    }

    public function exportPenjualanPDF(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $metode_pembayaran = $request->input('metode_pembayaran');
        $status = $request->input('status');

        // dd([
        //     'start' => $start,
        //     'end' => $end,
        //     'metode_pembayaran' => $metode_pembayaran,
        //     'status' => $status,
        // ]);

        $id_toko = session('id_toko');


        if (empty($start) && empty($end) && empty($metode_pembayaran) && empty($status)) {
            $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
                ->where('id_toko', $id_toko)->get();
            $pendapatan = $penjualans->sum('total');

            $fileName = 'laporan_penjualan_semua_periode.pdf';
        } else {
            try {
                $startFormatted = Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d');
                $endFormatted = Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('errortanggal', 'Format tanggal tidak valid.');
            }

            // Query data penjualan dengan filter
            $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
                ->where('id_toko', $id_toko)
                ->when($startFormatted && $endFormatted, function ($query) use ($startFormatted, $endFormatted) {
                    return $query->whereRaw('DATE(tanggal_pembayaran) BETWEEN ? AND ?', [$startFormatted, $endFormatted]);
                })
                ->when($metode_pembayaran, function ($query) use ($metode_pembayaran) {
                    return $query->where('metode_pembayaran', $metode_pembayaran);
                })
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->orderBy('tanggal_pembayaran', 'desc')
                ->get();

            $pendapatan = $penjualans->sum('total');

            $fileName = "laporan_penjualan-{$startFormatted} - {$endFormatted}.pdf";
        }

        // Buat view untuk PDF
        $pdf = PDF::loadView('laporan.cetak-lappenjualan.laporan_pdf', [
            'penjualans' => $penjualans,
            'start' => $start,
            'pendapatan' => $pendapatan,
            'end' => $end,
            'metode_pembayaran' => $metode_pembayaran,
            'status' => $status,
        ]);

        // Kembalikan PDF sebagai response
        return $pdf->download($fileName);
    }

    public function exportPenjualanXLS(Request $request)
    {
        // Ambil parameter start dan end dari request
        $start = $request->input('start');
        $end = $request->input('end');
        $metode_pembayaran = $request->input('metode_pembayaran');
        $status = $request->input('status');

        $id_toko = session('id_toko');

        if (empty($start) && empty($end) && empty($metode_pembayaran) && empty($status)) {
            $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
                ->where('id_toko', $id_toko)->get();
            $pendapatan = $penjualans->sum('total');
            // Jika semua parameter kosong, ambil semua data penjualan
            return Excel::download(new PenjualanExport(null, null, null, null, $pendapatan), 'laporan_penjualan_semua_periode.xlsx');
        } else {
            // Format tanggal start dan end
            try {
                $startFormatted = Carbon::createFromFormat('m/d/Y', $start)->format('Y-m-d');
                $endFormatted = Carbon::createFromFormat('m/d/Y', $end)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['msg' => 'Format tanggal salah: ' . $e->getMessage()]);
            }

            // Query data penjualan dengan filter
            $penjualans = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
                ->where('id_toko', $id_toko)
                ->when(
                    $startFormatted && $endFormatted,
                    function ($query) use ($startFormatted, $endFormatted) {
                        return $query->whereRaw('DATE(tanggal_pembayaran) BETWEEN ? AND ?', [$startFormatted, $endFormatted]);
                    }
                )
                ->when($metode_pembayaran, function ($query) use ($metode_pembayaran) {
                    return $query->where('metode_pembayaran', $metode_pembayaran);
                })
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->orderBy('tanggal_pembayaran', 'desc')
                ->get();

            $pendapatan = $penjualans->sum('total');
            $filename = "laporan_penjualan-{$startFormatted} - {$endFormatted}.xlsx";
            // Menginisialisasi kelas PenjualanExport dengan parameter yang diambil
            return Excel::download(new PenjualanExport($startFormatted, $endFormatted, $metode_pembayaran, $status, $pendapatan), $filename);
        }
    }

    // Method untuk menampilkan detail penjualan
    public function showDetail($nopenjualan)
    {
        // Ambil detail penjualan berdasarkan nopenjualan
        $penjualan = Penjualan::with(['detailPenjualan.satuan', 'konsumen', 'user'])
            ->where('nopenjualan', $nopenjualan)->first();
        $detailPenjualan = DetailPenjualan::where('nopenjualan', $nopenjualan)->get();

        return view('laporan.lappenjualan', [
            'penjualan' => $penjualan,
            'detailPenjualan' => $detailPenjualan,
        ]);
    }
}
