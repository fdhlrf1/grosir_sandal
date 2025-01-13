<?php

use App\Models\Ukuran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\WarnaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UkuranController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\KategoriController;
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

Route::middleware(['auth', 'admin'])->group(
    function () {
        Route::get('/admin/beranda', [AdminController::class, 'index'])->name('admin_beranda');

        Route::get('/databarang', [BarangController::class, 'index'])->name('databarang');
        Route::resource('/barang', BarangController::class);
        Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

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

        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::resource('/penjualan', TransaksiController::class);
        Route::post('/penjualan/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/reset', [TransaksiController::class, 'reset'])->name('transaksi.reset');
        Route::post('/add-to-cart', [TransaksiController::class, 'addToCart']);
        Route::post('/remove-from-cart/{index}', [TransaksiController::class, 'removeFromCart']);
        Route::get('/cetak-struk/{nopenjualan}', [TransaksiController::class, 'cetakStruk'])->name('cetakStruk');

        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        Route::resource('/pembelian', PembelianController::class);
        Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
        Route::get('/pembelian/reset', [PembelianController::class, 'reset'])->name('pembelian.reset');
        Route::post('/add-to-cart2', [PembelianController::class, 'addToCart2']);
        Route::post('/remove-from-cart2/{index}', [PembelianController::class, 'removeFromCart2']);
        Route::post('/item-details', [PembelianController::class, 'getItemDetails'])->name('item.details');

        Route::put('/pelunasan/{id}', [PelunasanController::class, 'update'])->name('pelunasan.update');
        Route::get('/get-ukuran/{idKategori}', [UkuranController::class, 'getUkuranByKategori']);
        Route::get('/get-motif/{idKategori}', [MotifController::class, 'getMotifByKategori']);
        Route::get('/get-motif-ukuran', [BarangController::class, 'getMotifUkuran']);
        Route::get('/testtoast', [TransaksiController::class, 'testToast'])->name('test_toast');


        Route::get('/lapharian', function () {
            return view('laporan/lapharian', ['title' => 'LaporanHarian']);
        });

        Route::prefix('laporanpenjualan')->group(function () {
            Route::get('/', [LaporanPenjualanController::class, 'index'])->name('laporanpenjualan.index');
            Route::get('/filter', [LaporanPenjualanController::class, 'filter'])->name('laporanpenjualan.filter');
            Route::get('/{nopenjualan}', [LaporanPenjualanController::class, 'showDetail'])->name('penjualan.detail');
            Route::get('/show', [LaporanPenjualanController::class, 'showLaporanPenjualan'])->name('laporanpenjualan.show');
            Route::get('/exportpdf', [LaporanPenjualanController::class, 'exportPenjualanPDF'])->name('laporanpenjualan.exportPDF');
            Route::get('/exportxls', [LaporanPenjualanController::class, 'exportPenjualanXLS'])->name('laporanpenjualan.exportXLS');
        });

        Route::prefix('laporanpembelian')->group(function () {
            Route::get('/', [LaporanPembelianController::class, 'index'])->name('laporanpembelian.index');
            Route::get('/filter', [LaporanPembelianController::class, 'filterPembelian'])->name('laporanpembelian.filter');
            Route::get('/{nopembelian}', [LaporanPembelianController::class, 'showDetailPembelian'])->name('pembelian.detail');
            Route::get('/show', [LaporanPembelianController::class, 'showLaporanPembelian'])->name('laporanpembelian.show');
            Route::get('/exportpdf', [LaporanPembelianController::class, 'exportPembelianPDF'])->name('laporanpembelian.exportPDF');
            Route::get('/exportxls', [LaporanPembelianController::class, 'exportPembelianXLS'])->name('laporanpembelian.exportXLS');
        });

        Route::prefix('laporanpersediaan')->group(function () {
            Route::get('/', [LaporanPersediaanController::class, 'index'])->name('laporanpersediaan.index');
            Route::get('/show', [LaporanPersediaanController::class, 'showLaporanPersediaan'])->name('laporanpersediaan.show');
            Route::get('/exportpdf', [LaporanPersediaanController::class, 'exportPersediaanPDF'])->name('laporanpersediaan.exportPDF');
            Route::get('/exportxls', [LaporanPersediaanController::class, 'exportPersediaanXLS'])->name('laporanpersediaan.exportXLS');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);

Route::middleware(['auth', 'kasir'])->group(
    function () {
        Route::get('/kasir/beranda', [KasirController::class, 'index'])->name('kasir_beranda');

        Route::get('/databarang', [BarangController::class, 'index'])->name('databarang');
        Route::resource('/barang', BarangController::class);
        Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

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

        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::resource('/penjualan', TransaksiController::class);
        Route::post('/penjualan/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/reset', [TransaksiController::class, 'reset'])->name('transaksi.reset');
        Route::post('/add-to-cart', [TransaksiController::class, 'addToCart']);
        Route::post('/remove-from-cart/{index}', [TransaksiController::class, 'removeFromCart']);
        Route::get('/cetak-struk/{nopenjualan}', [TransaksiController::class, 'cetakStruk'])->name('cetakStruk');

        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        Route::resource('/pembelian', PembelianController::class);
        Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
        Route::get('/pembelian/reset', [PembelianController::class, 'reset'])->name('pembelian.reset');
        Route::post('/add-to-cart2', [PembelianController::class, 'addToCart2']);
        Route::post('/remove-from-cart2/{index}', [PembelianController::class, 'removeFromCart2']);
        Route::post('/item-details', [PembelianController::class, 'getItemDetails'])->name('item.details');

        Route::put('/pelunasan/{id}', [PelunasanController::class, 'update'])->name('pelunasan.update');
        Route::get('/get-ukuran/{idKategori}', [UkuranController::class, 'getUkuranByKategori']);
        Route::get('/get-motif/{idKategori}', [MotifController::class, 'getMotifByKategori']);
        Route::get('/get-motif-ukuran', [BarangController::class, 'getMotifUkuran']);
        Route::get('/testtoast', [TransaksiController::class, 'testToast'])->name('test_toast');


        Route::get('/lapharian', function () {
            return view('laporan/lapharian', ['title' => 'LaporanHarian']);
        });

        Route::prefix('laporanpenjualan')->group(function () {
            Route::get('/', [LaporanPenjualanController::class, 'index'])->name('laporanpenjualan.index');
            Route::get('/filter', [LaporanPenjualanController::class, 'filter'])->name('laporanpenjualan.filter');
            Route::get('/{nopenjualan}', [LaporanPenjualanController::class, 'showDetail'])->name('penjualan.detail');
            Route::get('/show', [LaporanPenjualanController::class, 'showLaporanPenjualan'])->name('laporanpenjualan.show');
            Route::get('/exportpdf', [LaporanPenjualanController::class, 'exportPenjualanPDF'])->name('laporanpenjualan.exportPDF');
            Route::get('/exportxls', [LaporanPenjualanController::class, 'exportPenjualanXLS'])->name('laporanpenjualan.exportXLS');
        });

        Route::prefix('laporanpembelian')->group(function () {
            Route::get('/', [LaporanPembelianController::class, 'index'])->name('laporanpembelian.index');
            Route::get('/filter', [LaporanPembelianController::class, 'filterPembelian'])->name('laporanpembelian.filter');
            Route::get('/{nopembelian}', [LaporanPembelianController::class, 'showDetailPembelian'])->name('pembelian.detail');
            Route::get('/show', [LaporanPembelianController::class, 'showLaporanPembelian'])->name('laporanpembelian.show');
            Route::get('/exportpdf', [LaporanPembelianController::class, 'exportPembelianPDF'])->name('laporanpembelian.exportPDF');
            Route::get('/exportxls', [LaporanPembelianController::class, 'exportPembelianXLS'])->name('laporanpembelian.exportXLS');
        });

        Route::prefix('laporanpersediaan')->group(function () {
            Route::get('/', [LaporanPersediaanController::class, 'index'])->name('laporanpersediaan.index');
            Route::get('/show', [LaporanPersediaanController::class, 'showLaporanPersediaan'])->name('laporanpersediaan.show');
            Route::get('/exportpdf', [LaporanPersediaanController::class, 'exportPersediaanPDF'])->name('laporanpersediaan.exportPDF');
            Route::get('/exportxls', [LaporanPersediaanController::class, 'exportPersediaanXLS'])->name('laporanpersediaan.exportXLS');
        });

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);

// Route::middleware(['auth'])->group(
//     function () {
        // Route::get('/admin/beranda', [AdminController::class, 'index'])->name('admin_beranda');
        // Route::get('/kasir/beranda', [KasirController::class, 'index'])->name('kasir_beranda');

        // Route::get('/beranda', function () {
        //     return view('beranda', ['title' => 'Beranda']);
        // })->name('beranda');

        // Route::get('/', function () {
        //     return view('beranda', ['title' => 'Beranda']);
        // });
        // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Route::get('/databarang', [BarangController::class, 'index'])->name('databarang');
        // Route::resource('/barang', BarangController::class);
        // Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

        // Route::get('/datakonsumen', [KonsumenController::class, 'index'])->name('datakonsumen');
        // Route::resource('/konsumen', KonsumenController::class);
        // Route::put('/konsumen/{id}', [KonsumenController::class, 'update'])->name('konsumen.update');
        // Route::delete('/konsumen/{id}', [KonsumenController::class, 'destroy'])->name('konsumen.destroy');

        // Route::get('/datasatuan', [SatuanController::class, 'index'])->name('datasatuan');
        // Route::resource('/satuan', SatuanController::class);
        // Route::put('/satuan/{id}', [SatuanController::class, 'update'])->name('satuan.update');
        // Route::delete('/satuan/{id}', [SatuanController::class, 'destroy'])->name('satuan.destroy');

        // Route::get('/datakategori', [KategoriController::class, 'index'])->name('datakategori');
        // Route::resource('/kategori', KategoriController::class);
        // Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        // Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Route::get('/datapemasok', [PemasokController::class, 'index'])->name('datapemasok');
        // Route::resource('/pemasok', PemasokController::class);
        // Route::put('/pemasok/{id}', [PemasokController::class, 'update'])->name('pemasok.update');
        // Route::delete('/pemasok/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');

        // Route::get('/datamotif', [MotifController::class, 'index'])->name('datamotif');
        // Route::resource('/motif', MotifController::class);
        // Route::put('/motif/{id}', [MotifController::class, 'update'])->name('motif.update');
        // Route::delete('/motif/{id}', [MotifController::class, 'destroy'])->name('motif.destroy');

        // Route::get('/dataukuran', [UkuranController::class, 'index'])->name('dataukuran');
        // Route::resource('/ukuran', UkuranController::class);
        // Route::put('/ukuran/{id}', [UkuranController::class, 'update'])->name('ukuran.update');
        // Route::delete('/ukuran/{id}', [UkuranController::class, 'destroy'])->name('ukuran.destroy');


        // Route::get('/penjualan', [TransaksiController::class, 'index'])->name('penjualan');

        // Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        // Route::resource('/penjualan', TransaksiController::class);
        // Route::post('/penjualan/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        // Route::get('/transaksi/reset', [TransaksiController::class, 'reset'])->name('transaksi.reset');
        // Route::post('/add-to-cart', [TransaksiController::class, 'addToCart']);
        // Route::post('/remove-from-cart/{index}', [TransaksiController::class, 'removeFromCart']);
        // Route::get('/cetak-struk/{nopenjualan}', [TransaksiController::class, 'cetakStruk'])->name('cetakStruk');

        // Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        // Route::resource('/pembelian', PembelianController::class);
        // Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
        // Route::get('/pembelian/reset', [PembelianController::class, 'reset'])->name('pembelian.reset');
        // Route::post('/add-to-cart2', [PembelianController::class, 'addToCart2']);
        // Route::post('/remove-from-cart2/{index}', [PembelianController::class, 'removeFromCart2']);
        // Route::post('/item-details', [PembelianController::class, 'getItemDetails'])->name('item.details');

        // Route::get('/pelunasan', [PelunasanController::class, 'index'])->name('pelunasan.index');

        // Route::put('/pelunasan/{id}', [PelunasanController::class, 'update'])->name('pelunasan.update');
        // Route::get('/get-ukuran/{idKategori}', [UkuranController::class, 'getUkuranByKategori']);
        // Route::get('/get-motif/{idKategori}', [MotifController::class, 'getMotifByKategori']);
        // Route::get('/get-motif-ukuran', [BarangController::class, 'getMotifUkuran']);
        // Route::get('/testtoast', [TransaksiController::class, 'testToast'])->name('test_toast');



        // Route::get('/lapharian', function () {
        //     return view('laporan/lapharian', ['title' => 'LaporanHarian']);
        // });
        // Route::get('/lappenjualan', [LaporanPenjualanController::class, 'index'])->name('laporanpenjualan.index');
        // Route::get('/lappenjualanfilter', [LaporanPenjualanController::class, 'filter'])->name('laporanpenjualan.filter');
        // Route::get('/lappenjualan/{nopenjualan}', [LaporanPenjualanController::class, 'showDetail'])->name('penjualan.detail');
        // Route::get('/lappenjualanshow', [LaporanPenjualanController::class, 'showLaporanPenjualan'])->name('laporanpenjualan.show');
        // Route::get('/lappenjualanexportpdf', [LaporanPenjualanController::class, 'exportPenjualanPDF'])->name('laporanpenjualan.exportPDF');
        // Route::get('/lappenjualanexportxls', [LaporanPenjualanController::class, 'exportPenjualanXLS'])->name('laporanpenjualan.exportXLS');

        // Route::get('/lappembelian', [LaporanPembelianController::class, 'index'])->name('laporanpembelian.index');
        // Route::get('/lappembelianfilter', [LaporanPembelianController::class, 'filterPembelian'])->name('laporanpembelian.filter');
        // Route::get('/lappembelian/{nopembelian}', [LaporanPembelianController::class, 'showDetailPembelian'])->name('pembelian.detail');
        // Route::get('/lappembelianshow', [LaporanPembelianController::class, 'showLaporanPembelian'])->name('laporanpembelian.show');
        // Route::get('/lappembelianexportpdf', [LaporanPembelianController::class, 'exportPembelianPDF'])->name('laporanpembelian.exportPDF');
        // Route::get('/lappembelianexportxls', [LaporanPembelianController::class, 'exportPembelianXLS'])->name('laporanpembelian.exportXLS');

        // Route::get('/lappersediaan', [LaporanPersediaanController::class, 'index'])->name('laporanpersediaan.index');
        // Route::get('/lappersediaanshow', [LaporanPersediaanController::class, 'showLaporanPersediaan'])->name('laporanpersediaan.show');
        // Route::get('/lappersediaanexportpdf', [LaporanPersediaanController::class, 'exportPersediaanPDF'])->name('laporanpersediaan.exportPDF');
        // Route::get('/lappersediaanexportxls', [LaporanPersediaanController::class, 'exportPersediaanXLS'])->name('laporanpersediaan.exportXLS');
//     }
// );