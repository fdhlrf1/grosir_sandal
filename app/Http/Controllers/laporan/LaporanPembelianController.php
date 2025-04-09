<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\PembelianExport;
use Barryvdh\DomPDF\PDF;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailPembelian;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPembelianController extends Controller
{
    //
    public function index()
    {
        $id_user = session('id_user');
        $id_toko = session('id_toko');
        $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
            ->where('id_toko', $id_toko)->latest()->simplePaginate(5);

        return view('laporan.lappembelian', [
            'title' => 'Laporan Pembelian',
            'pembelians' => $pembelians,
        ]);
    }

    public function filterPembelian(Request $request)
    {
        $start2 = $request->input('start2');
        $end2 = $request->input('end2');

        // Pastikan kedua tanggal tidak kosong
        if (empty($start2) || empty($end2)) {
            return redirect()->back()->with('errortanggal', 'Tanggal mulai dan tanggal akhir harus diisi');
        }

        $start2Formatted = Carbon::createFromFormat('m/d/Y', $start2)->format('Y-m-d');
        $end2Formatted = Carbon::createFromFormat('m/d/Y', $end2)->format('Y-m-d');

        $id_toko = session('id_toko');

        $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
            ->where('id_toko', $id_toko)
            ->when($start2Formatted && $end2Formatted, function ($query) use ($start2Formatted, $end2Formatted) {
                // dd('star$start2Formatted Date:', $start2Formatted, 'end2$end2Formatted Date:', $end2Formatted);
                return $query->whereRaw('DATE(tanggal_pembelian) BETWEEN ? AND ?', [$start2Formatted, $end2Formatted]);
            })->simplePaginate(10);

        return view('laporan.lappembelian', [
            'title' => 'Laporan Pembelian',
            'pembelians' => $pembelians,
        ]);
    }

    public function showLaporanPembelian(Request $request)
    {
        $start2 = $request->input('start2');
        $end2 = $request->input('end2');

        $id_toko = session('id_toko');

        if (empty($start2) && empty($end2) && empty($metode) && empty($status)) {
            $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
                ->where('id_toko', $id_toko)->get();

            $pengeluaran = $pembelians->sum('total');
        } elseif (empty($start2) || empty($end2)) {
            return redirect()->back()->with('errortanggal', 'Tanggal mulai dan tanggal akhir harus diisi');
        } else {
            try {
                $start2Formatted = Carbon::createFromFormat('m/d/Y', $start2)->format('Y-m-d');
                $end2Formatted = Carbon::createFromFormat('m/d/Y', $end2)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('errortanggal', 'Format tanggal tidak valid.');
            }
            // Query data Pembelian dengan filter
            $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
                ->where('id_toko', $id_toko)
                ->when($start2Formatted && $end2Formatted, function ($query) use ($start2Formatted, $end2Formatted) {
                    return $query->whereRaw('DATE(tanggal_pembelian) BETWEEN ? AND ?', [$start2Formatted, $end2Formatted]);
                })->orderBy('tanggal_pembelian', 'desc')->get();

            $pengeluaran = $pembelians->sum('total');
        }

        // Passing data ke view
        return view('laporan.cetak-lappembelian.show-laporan-pembelian', [
            'title' => 'Show Laporan Penjualan',
            'pengeluaran' => $pengeluaran,
            'pembelians' => $pembelians,
            'start2' => $start2,
            'end2' => $end2,
        ]);
    }

    public function exportPembelianPDF(Request $request)
    {
        $start2 = $request->input('start2');
        $end2 = $request->input('end2');

        // dd([
        //     'start2' => $start2,
        //     'end2' => $end2,
        //     'metode_pembayaran' => $metode_pembayaran,
        //     'status' => $status,
        // ]);

        $id_toko = session('id_toko');


        if (empty($start2) && empty($end2)) {
            $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
                ->where('id_toko', $id_toko)->get();
            $pengeluaran = $pembelians->sum('total');

            $filename = 'laporan_pembelian_semua_periode.pdf';
        } else {
            try {
                $start2Formatted = Carbon::createFromFormat('m/d/Y', $start2)->format('Y-m-d');
                $end2Formatted = Carbon::createFromFormat('m/d/Y', $end2)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('errortanggal', 'Format tanggal tidak valid.');
            }

            // Query data penjualan dengan filter
            $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
                ->where('id_toko', $id_toko)
                ->when($start2Formatted && $end2Formatted, function ($query) use ($start2Formatted, $end2Formatted) {
                    return $query->whereRaw('DATE(tanggal_pembelian) BETWEEN ? AND ?', [$start2Formatted, $end2Formatted]);
                })
                ->orderBy('tanggal_pembelian', 'desc')
                ->get();

            $pengeluaran = $pembelians->sum('total');

            $filename = "laporan_pembelian-{$start2Formatted} - {$end2Formatted}.pdf";
        }

        // Buat instansi dari PDF dan muat view
        $pdf = app('dompdf.wrapper')->loadView('laporan.cetak-lappembelian.laporan_pdf', [
            'pembelians' => $pembelians,
            'start2' => $start2,
            'end2' => $end2,
            'pengeluaran' => $pengeluaran,
        ]);

        // Download PDF
        return $pdf->download($filename);
    }

    public function exportPembelianXLS(Request $request)
    {
        // Ambil parameter start2 dan end2 dari request
        $start2 = $request->input('start2');
        $end2 = $request->input('end2');

        // dd([
        //     'start2' => $start2,
        //     'end2' => $end2,
        // ]);

        $id_toko = session('id_toko');

        if (empty($start2) && empty($end2)) {
            $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
                ->where('id_toko', $id_toko)->get();
            $pengeluaran = $pembelians->sum('total');
            // Jika semua parameter kosong, ambil semua data penjualan
            return Excel::download(new PembelianExport(null, null, $pengeluaran), 'laporan_pembelian_semua_periode.xlsx');
        } else {
            // Format tanggal start2 dan end2
            try {
                $start2Formatted = Carbon::createFromFormat('m/d/Y', $start2)->format('Y-m-d');
                $end2Formatted = Carbon::createFromFormat('m/d/Y', $end2)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['msg' => 'Format tanggal salah: ' . $e->getMessage()]);
            }

            $pembelians = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
                ->where('id_toko', $id_toko)
                ->when(
                    $start2Formatted && $end2Formatted,
                    function ($query) use ($start2Formatted, $end2Formatted) {
                        return $query->whereRaw('DATE(tanggal_pembelian) BETWEEN ? AND ?', [$start2Formatted, $end2Formatted]);
                    }
                );
            $pengeluaran = $pembelians->sum('total');
            $filename = "laporan_pembelian-{$start2Formatted} - {$end2Formatted}.xlsx";
            // Menginisialisasi kelas PembelianExport dengan parameter yang diambil
            return Excel::download(new PembelianExport($start2Formatted, $end2Formatted, $pengeluaran), $filename);
        }
    }

    public function showDetailPembelian($nopembelian)
    {
        $pembelian = Pembelian::with('detailPembelian.satuan', 'user', 'pemasok')
            ->where('nopembelian', $nopembelian)->first();
        $detailPembelian = DetailPembelian::where('nopembelian', $nopembelian)->get();

        return view('laporan.lappembelian', [
            'pembelian' => $pembelian,
            'detailPembelian' => $detailPembelian,
        ]);
    }
}
