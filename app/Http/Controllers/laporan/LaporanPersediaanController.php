<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Exports\PersediaanExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\returnSelf;

class LaporanPersediaanController extends Controller
{
    //
    public function index()
    {
        // $persediaans = DB::table('tkategori')
        //     ->join('tbarang', 'tkategori.id_kategori', '=', 'tbarang.id_kategori')
        //     ->select('tkategori.nama as kategori', DB::raw('SUM(tbarang.stok) as total_stok'))
        //     ->groupBy('tkategori.nama')
        //     ->get();

        $id_toko = session('id_toko');

        $persediaans = DB::table('tkategori')
            ->join('tbarang', function ($join) use ($id_toko) {
                $join->on('tkategori.id_kategori', '=', 'tbarang.id_kategori')
                    ->where('tkategori.id_toko', '=', $id_toko)
                    ->where('tbarang.id_toko', '=', $id_toko);
            })
            ->select('tkategori.nama as kategori', DB::raw('SUM(tbarang.stok) as total_stok'))
            ->groupBy('tkategori.nama')
            ->get();


        // dd($persediaans);

        return view('laporan.lappersediaan', [
            'persediaans' => $persediaans,
            'title' => 'Laporan Persediaan',
        ]);
    }

    public function showLaporanPersediaan(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $now = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $id_toko = session('id_toko');

        $persediaans = DB::table('tkategori')
            ->join('tbarang', function ($join) use ($id_toko) {
                $join->on('tkategori.id_kategori', '=', 'tbarang.id_kategori')
                    ->where('tkategori.id_toko', '=', $id_toko)
                    ->where('tbarang.id_toko', '=', $id_toko);
            })
            ->select('tkategori.nama as kategori', DB::raw('SUM(tbarang.stok) as total_stok'))
            ->groupBy('tkategori.nama')
            ->get();

        // Passing data ke view
        return view('laporan.cetak-lappersediaan.show-laporan-persediaan', [
            'title' => 'Show Laporan Persediaan',
            'persediaans' => $persediaans,
            'now' => $now,
        ]);
    }

    public function exportPersediaanPDF(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $now = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $id_toko = session('id_toko');

        $persediaans = DB::table('tkategori')
            ->join('tbarang', function ($join) use ($id_toko) {
                $join->on('tkategori.id_kategori', '=', 'tbarang.id_kategori')
                    ->where('tkategori.id_toko', '=', $id_toko)
                    ->where('tbarang.id_toko', '=', $id_toko);
            })
            ->select('tkategori.nama as kategori', DB::raw('SUM(tbarang.stok) as total_stok'))
            ->groupBy('tkategori.nama')
            ->get();

        // Buat instansi dari PDF dan muat view
        $pdf = app('dompdf.wrapper')->loadView('laporan.cetak-lappersediaan.laporan_pdf', [
            'persediaans' => $persediaans,
            'now' => $now,
        ]);
        $filename = "laporan_persediaan-{$now}.pdf";
        // Download PDF
        return $pdf->download($filename);
    }

    public function exportPersediaanXLS(Request $request)
    {
        \Carbon\Carbon::setLocale('id');
        $now = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $id_toko = session('id_toko');

        $persediaans = DB::table('tkategori')
            ->join('tbarang', function ($join) use ($id_toko) {
                $join->on('tkategori.id_kategori', '=', 'tbarang.id_kategori')
                    ->where('tkategori.id_toko', '=', $id_toko)
                    ->where('tbarang.id_toko', '=', $id_toko);
            })
            ->select('tkategori.nama as kategori', DB::raw('SUM(tbarang.stok) as total_stok'))
            ->groupBy('tkategori.nama')
            ->get();

        $filename = "laporan_persediaan-{$now}.xlsx";
        return Excel::download(new PersediaanExport($persediaans), $filename);
    }
}
