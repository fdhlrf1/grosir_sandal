<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Konsumen;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class TransaksiController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_user dari session
        $id_user = session('id_user');

        // Simpan status modal ke session
        $showModal = $request->has('show_modal');

        // Ambil data barang dengan filter berdasarkan id_user dan pencarian
        $barangs = Barang::with('pemasok', 'satuan', 'kategori')
            ->where('id_user', $id_user)
            ->when($search, function ($query, $search) {
                return $query->where('warna', 'like', "%{$search}%")
                    ->orWhere('kd_barang', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($query) use ($search) {
                        $query->where('warna', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        $kategoris = Kategori::all();
        $konsumens = Konsumen::all();

        // Cek apakah sudah ada nopenjualan di session
        if (!session()->has('nopenjualan')) {
            // Generate tanggal hari ini
            $today = Carbon::now()->format('Ymd');
            // Mencari nopenjualan terakhir
            $lastTransaksi = Penjualan::where('nopenjualan', 'LIKE', $today . '%')
                ->orderBy('nopenjualan', 'desc')
                ->first();

            if ($lastTransaksi) {
                // Jika ada transaksi terakhir, ambil nomor urut terakhir
                $lastNoUrut = (int) substr($lastTransaksi->nopenjualan, 8, 4);
            } else {
                // Jika belum ada transaksi pada hari ini, mulai dari 0
                $lastNoUrut = 0;
            }

            // Nomor urut transaksi berikutnya
            $nextNoUrut = $lastNoUrut + 1;

            // Format nomor transaksi berikutnya dengan 4 digit nomor urut
            $nextNoTransaksi = $today . sprintf('%04s', $nextNoUrut);

            // Simpan nopenjualan ke session
            session(['nopenjualan' => $nextNoTransaksi]);
        }

        return view('transaksi.penjualan_mt', [
            'title' => 'Data Konsumen',
            'konsumens' => $konsumens,
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'showModal' => $showModal,
            'nopenjualan' => session('nopenjualan'),
        ]);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'no_transaksi' => 'required',
            'nama_konsumen' => 'required',
            'kd_barang' => 'required|string|max:50',
            'kategori' => 'required',
            'h_jual' => 'required|numeric',
            'qty' => 'required|numeric|min:1',
            'satuan' => 'required',
            'metode_pembayaran' => 'required',
            'paymentKredit' => ['nullable', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->metode_pembayaran === 'kredit' && is_null($value)) {
                    $fail('DP harus diisi jika metode pembayaran adalah kredit.');
                }
            }], // Validasi untuk DP jika menggunakan metode Kredit
        ]);

        // Cek stok barang
        $barang = Barang::where('kd_barang', $request->kd_barang)->first();
        if ($barang->stok < $request->qty) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Simpan data form ke session
        session()->put('form_data.metode_pembayaran', $request->metode_pembayaran);
        session()->put('form_data.paymentKredit', $request->paymentKredit); // Simpan nominal DP jika ada

        // Ambil data konsumen dari database berdasarkan nama
        $konsumen = Konsumen::where('nama', $request->nama_konsumen)->first();
        $satuan = Satuan::where('nama_satuan', $request->satuan)->first();


        // Jika konsumen ditemukan, simpan id_konsumen, alamat, dan telepon ke session
        if ($konsumen) {
            session()->put('form_data.nama_konsumen', $konsumen->id_konsumen);
            session()->put('form_data.alamat', $konsumen->alamat);
            session()->put('form_data.telepon', $konsumen->telepon);
        }
        if ($satuan) {
            session()->put('form_data.satuan', $satuan->id_satuan);
        }

        $cartItem = [
            'nopenjualan' => $request->no_transaksi,
            'id_konsumen' => session('form_data.nama_konsumen'),
            'id_user' => session('id_user'),
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->paymentKredit > 0 ? 'Belum Lunas' : 'Lunas', // Status berdasarkan DP
            'dp' => $request->paymentKredit, // Simpan DP jika ada
            //detail
            'satuan' => session('form_data.satuan'),
            'kd_barang' => $request->kd_barang,
            'harga' => $request->h_jual,
            'kuantitas' => $request->qty,
            'subtotal' => $request->h_jual * $request->qty,
            'kategori' => $request->kategori,
        ];

        // Ambil keranjang dari session atau buat array kosong jika belum ada
        $cart = session()->get('cart', []);

        // Tambahkan item ke dalam keranjang
        $cart[] = $cartItem;

        // Simpan kembali keranjang ke session
        session()->put('cart', $cart);

        // Redirect atau kembalikan view
        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'total' => 'required|numeric|min:0',
            'kembalian' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
        ]);

        session(['total' => $request->total]);
        session(['kembalian' => $request->kembalian]);
        session(['bayar' => $request->bayar]);

        // Ambil nomor transaksi dari session
        $nopenjualan = session('nopenjualan');

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Ambil data dari keranjang
        $id_konsumen = $cart[0]['id_konsumen'];
        $metode_pembayaran = $cart[0]['metode_pembayaran'];
        $status = $cart[0]['status'];
        $dp = $cart[0]['dp'];

        $tanggalLunas = $status === 'Lunas' ? now() : null;
        $jumlahPelunasan = $status === 'Lunas' ? $request->total : $dp;

        $penjualan = Penjualan::create([
            'nopenjualan' => $nopenjualan,
            'id_konsumen' => $id_konsumen,
            'id_user' => session('id_user'),
            'total' => $request->total,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian,
            'tanggal_pembayaran' => now(),
            'metode_pembayaran' => $metode_pembayaran,
            'status' => $status,
            'dp' => $dp,
            'tanggal_lunas' => $tanggalLunas,
            'jumlah_pelunasan' => $jumlahPelunasan, // atau sesuai kebutuhan
        ]);

        foreach ($cart as $item) {
            DetailPenjualan::create([
                'nopenjualan' => $nopenjualan, // Ambil nomor penjualan dari request atau transaksi
                'id_satuan' => $item['satuan'], // Ambil ID satuan dari item keranjang
                'kd_barang' => $item['kd_barang'], // Ambil kode barang dari item keranjang
                'h_jual' => $item['harga'], // Ambil harga jual dari item keranjang
                'qty' => $item['kuantitas'], // Ambil kuantitas dari item keranjang
                'subtotal' => $item['subtotal'], // Ambil subtotal dari item keranjang
            ]);
        }

        // Mengurangi stok barang
        $barang = Barang::where('kd_barang', $item['kd_barang'])->first();
        if ($barang) {
            $barang->stok -= $item['kuantitas'];
            $barang->save();
        }

        // Hapus nomor transaksi dari session untuk memulai transaksi baru
        session(['nopenjualan' => null]);

        // Bersihkan keranjang setelah transaksi disimpan
        session()->forget(['cart', 'total', 'bayar', 'kembalian', 'form_data']);

        // Redirect atau berikan respons sukses
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function removefromCart($index)
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Hapus item berdasarkan index
        unset($cart[$index]);

        $cart = array_values($cart); // Reindex array

        // Simpan kembali ke session
        session()->put('cart', $cart);

        // Redirect atau kembalikan view
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function reset(Request $request)
    {
        // Hapus nopenjualan dari session
        $request->session()->forget('nopenjualan');

        // Hapus session yang menyimpan data form
        $request->session()->forget('form_data');

        // Redirect kembali ke halaman transaksi
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil di-reset.');
    }



    public function show(string $id) {}
}
