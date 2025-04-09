<?php

use App\Models\Ukuran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\WarnaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UkuranController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelolaController;
use App\Http\Controllers\KelolaKasirController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\PelunasanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\laporan\LaporanPembelianController;
use App\Http\Controllers\laporan\LaporanPenjualanController;
use App\Http\Controllers\laporan\LaporanPersediaanController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);

    Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register']);
});

Route::middleware(['auth'])->group(
    function () {
        // Route::get('/admin/beranda', [BerandaController::class, 'indexAdmin'])->name('admin_beranda');
        // Route::get('/kasir/beranda', [BerandaController::class, 'indexKasir'])->name('kasir_beranda');

        Route::get('/scroll', function () {
            return view('scroll');
        });

        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/databarang', [BarangController::class, 'index'])->name('databarang');
        Route::resource('/barang', BarangController::class);
        Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::put('/barang/hapusgambar/{id}', [BarangController::class, 'hapusGambar'])->name('barang.hapus');


        Route::get('/datakonsumen', [KonsumenController::class, 'index'])->name('datakonsumen');
        Route::resource('/konsumen', KonsumenController::class);
        Route::put('/konsumen/{id}', [KonsumenController::class, 'update'])->name('konsumen.update');
        Route::delete('/konsumen/{id}', [KonsumenController::class, 'destroy'])->name('konsumen.destroy');

        Route::get('/datasatuan', [SatuanController::class, 'index'])->name('datasatuan');
        Route::resource('/satuan', SatuanController::class);
        Route::put('/satuan/{id}', [SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/satuan/{id}', [SatuanController::class, 'destroy'])->name('satuan.destroy');

        Route::get('/datakategori', [KategoriController::class, 'index'])->name('datakategori');
        Route::resource('/kategori', KategoriController::class);
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        Route::get('/datapemasok', [PemasokController::class, 'index'])->name('datapemasok');
        Route::resource('/pemasok', PemasokController::class);
        Route::put('/pemasok/{id}', [PemasokController::class, 'update'])->name('pemasok.update');
        Route::delete('/pemasok/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');

        Route::get('/datamotif', [MotifController::class, 'index'])->name('datamotif');
        Route::resource('/motif', MotifController::class);
        Route::put('/motif/{id}', [MotifController::class, 'update'])->name('motif.update');
        Route::delete('/motif/{id}', [MotifController::class, 'destroy'])->name('motif.destroy');

        Route::get('/dataukuran', [UkuranController::class, 'index'])->name('dataukuran');
        Route::resource('/ukuran', UkuranController::class);
        Route::put('/ukuran/{id}', [UkuranController::class, 'update'])->name('ukuran.update');
        Route::delete('/ukuran/{id}', [UkuranController::class, 'destroy'])->name('ukuran.destroy');


        Route::get('/penjualan', [TransaksiController::class, 'index'])->name('penjualan');
        Route::resource('/penjualan', TransaksiController::class);

        Route::post('/penjualan/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/reset', [TransaksiController::class, 'reset'])->name('transaksi.reset');
        Route::post('/add-to-cart', [TransaksiController::class, 'addToCart'])->name('tambah_keranjang');
        // Route::post('/simpan-data-konsumen', [TransaksiController::class, 'simpanDataKonsumen']);
        Route::post('/remove-from-cart/{index}', [TransaksiController::class, 'removeFromCart']);

        Route::get('/cetak-struk/{nopenjualan}', [TransaksiController::class, 'cetakStruk'])->name('cetakStruk');

        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        Route::get('/pembelian/reset', [PembelianController::class, 'reset'])->name('pembelian.reset');
        Route::resource('/pembelian', PembelianController::class);
        Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
        Route::post('/add-to-cart2', [PembelianController::class, 'addToCart2']);
        // Route::post('/simpan-data-konsumen', [PembelianController::class, 'simpanDataKonsumen']);
        Route::post('/remove-from-cart2/{index}', [PembelianController::class, 'removeFromCart2']);
        // Route::post('/barang-details', [PembelianController::class, ''])
        Route::post('/item-details', [PembelianController::class, 'getItemDetails'])->name('item.details');

        // Route::get('/pelunasan', [PelunasanController::class, 'index'])->name('pelunasan.index');
        Route::put('/pelunasan/{id}', [PelunasanController::class, 'update'])->name('pelunasan.update');

        // Ambil ukuran berdasarkan kategori
        Route::get('/get-ukuran/{idKategori}', [UkuranController::class, 'getUkuranByKategori']);
        // Ambil motif berdasarkan kategori
        Route::get('/get-motif/{idKategori}', [MotifController::class, 'getMotifByKategori']);

        Route::get('/get-motif-ukuran', [BarangController::class, 'getMotifUkuran']);


        Route::get('/test-toast', [TransaksiController::class, 'showtoast'])->name('test_toast');

        Route::get('/kelolakasir', [KelolaKasirController::class, 'index'])->name('kelolakasir.index');
        Route::resource('/kelolakasir', KelolaKasirController::class);
        Route::put('/kelolakasir/{id}', [KelolaKasirController::class, 'update'])->name('kelolakasir.update');
        Route::delete('/kelolakasir/{id}', [KelolaKasirController::class, 'destroy'])->name('kelolakasir.destroy');

        Route::get('/lapharian', function () {
            return view('laporan/lapharian', ['title' => 'LaporanHarian']);
        });
        Route::get('/lappenjualan2', [TransaksiController::class, 'backToLapPenjualan'])->name('kembali_ke_laporan_penjualan');
        Route::get('/lappenjualan', [LaporanPenjualanController::class, 'index'])->name('laporanpenjualan.index');
        Route::get('/lappenjualanfilter', [LaporanPenjualanController::class, 'filter'])->name('laporanpenjualan.filter');
        Route::get('/lappenjualan/{nopenjualan}', [LaporanPenjualanController::class, 'showDetail'])->name('penjualan.detail');
        Route::get('/lappenjualanshow', [LaporanPenjualanController::class, 'showLaporanPenjualan'])->name('laporanpenjualan.show');
        Route::get('/lappenjualanexportpdf', [LaporanPenjualanController::class, 'exportPenjualanPDF'])->name('laporanpenjualan.exportPDF');
        Route::get('/lappenjualanexportxls', [LaporanPenjualanController::class, 'exportPenjualanXLS'])->name('laporanpenjualan.exportXLS');

        Route::get('/lappembelian', [LaporanPembelianController::class, 'index'])->name('laporanpembelian.index');
        Route::get('/lappembelianfilter', [LaporanPembelianController::class, 'filterPembelian'])->name('laporanpembelian.filter');
        Route::get('/lappembelian/{nopembelian}', [LaporanPembelianController::class, 'showDetailPembelian'])->name('pembelian.detail');
        Route::get('/lappembelianshow', [LaporanPembelianController::class, 'showLaporanPembelian'])->name('laporanpembelian.show');
        Route::get('/lappembelianexportpdf', [LaporanPembelianController::class, 'exportPembelianPDF'])->name('laporanpembelian.exportPDF');
        Route::get('/lappembelianexportxls', [LaporanPembelianController::class, 'exportPembelianXLS'])->name('laporanpembelian.exportXLS');

        Route::get('/lappersediaan', [LaporanPersediaanController::class, 'index'])->name('laporanpersediaan.index');
        Route::get('/lappersediaanshow', [LaporanPersediaanController::class, 'showLaporanPersediaan'])->name('laporanpersediaan.show');
        Route::get('/lappersediaanexportpdf', [LaporanPersediaanController::class, 'exportPersediaanPDF'])->name('laporanpersediaan.exportPDF');
        Route::get('/lappersediaanexportxls', [LaporanPersediaanController::class, 'exportPersediaanXLS'])->name('laporanpersediaan.exportXLS');
    }
);