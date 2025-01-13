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

        // dd($id_user);

        // Simpan status modal ke session
        $showModal = $request->has('show_modal');

        // Ambil data barang dengan filter berdasarkan id_user dan pencarian
        $barangs = Barang::with('pemasok', 'satuan', 'kategori')
            ->where('id_user', $id_user)
            ->when($search, function ($query, $search) {
                return $query->where('warna', 'like', "%{$search}%")
                    ->orWhere('kd_barang', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($query) use ($search) {
                        $query->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        // $kategoris = Kategori::all();
        // $konsumens = Konsumen::all();

        $kategoris = Kategori::where('id_user', $id_user)
            ->latest()
            ->paginate(10);

        $konsumens = Konsumen::where('id_user', $id_user)
            ->latest()
            ->paginate(10);

        $satuans = Satuan::where('id_user', $id_user)
            ->latest()
            ->paginate(10);


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

        return view('transaksi.penjualan', [
            'title' => 'Data Konsumen',
            'konsumens' => $konsumens,
            'barangs' => $barangs,
            'satuans' => $satuans,
            'kategoris' => $kategoris,
            'showModal' => $showModal,
            'nopenjualan' => session('nopenjualan'),
        ]);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        // try {

        // Validasi input
        $validated =  $request->validate([
            'kd_barang' => 'required',
            'no_transaksi' => 'required',
            'nama_konsumen' => 'required',
            'kd_barang' => 'required|string|max:50',
            'kategori' => 'required',
            'h_jual' => 'required|numeric',
            'qty' => 'required|numeric|min:0',
            'id_satuan' => 'required|string|numeric|exists:tsatuan,id_satuan',
            'metode_pembayaran' => 'required',
            'paymentKredit' => ['nullable', 'string', 'regex:/^Rp\. [0-9]{1,3}(?:\.[0-9]{3})*$/', function ($attribute, $value, $fail) use ($request) {
                if ($request->metode_pembayaran === 'kredit' && (is_null($value) || $value === '')) {
                    $fail('DP harus diisi jika metode pembayaran adalah kredit.');
                }
            }], // Validasi untuk DP jika menggunakan metode Kredit
        ]);

        //     dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->validator->errors()->all()); // Menampilkan semua kesalahan validasi
        // }

        // Ambil data satuan dan konversinya
        $satuan = Satuan::where('id_satuan', $request->id_satuan)->first();
        $konversi = $satuan->konversi;
        $namaSatuan = $satuan->nama_satuan;

        // Inisialisasi stok dalam Pcs dan Kodi
        $stokDalamPcs = 0;
        $stokDalamKodi = 0;
        $kuantitas = 0;

        $stokDalamPcsDB = 0;
        $stokDalamKodiDB = 0;

        // dd($request->id_satuan);

        if ($namaSatuan === 'Kodi') {
            $stokDalamPcs = $request->qty * $konversi;
            $stokDalamKodi = $request->qty;

            $subtotalkodi = $request->h_jual * $stokDalamKodi; // Harga beli per Kodi
            // dd($subtotalkodi);
            $kuantitas = $stokDalamKodi;

            // dd('Kodi', $stokDalamPcs, $subtotal);
        } else if ($namaSatuan === 'Pcs') {
            $stokDalamPcs = $request->qty;
            $stokDalamKodi = $request->qty / $konversi;

            $h_jual = $request->h_jual;

            $hargaperpcs = $h_jual / $konversi;
            $subtotalpcs = $hargaperpcs * $stokDalamPcs;
            $kuantitas = $stokDalamPcs;

            // dd(
            //     'Pcs',
            //     $h_jual,
            //     $hargaperpcs,
            //     $stokDalamPcs,
            //     $subtotal
            // );
        } else {
            return redirect()->route('penjualan.index')->with(['error' => 'Satuan tidak ditemukan']);
        }

        // dd($subtotal);


        // dd([
        //     'stok_dalam_pcs' => $stokDalamPcs,
        //     'stok_dalam_kodi' => $stokDalamKodi,
        //     'subtotal' => $subtotal,
        // ]);

        // Cek stok barang
        $barang = Barang::where('kd_barang', $request->kd_barang)->first();
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        // Cek stok dalam satuan Kodi dan Pcs
        $stokDalamPcsDB = $barang->stok;

        // Hitung jumlah kuantitas yang akan ditambahkan ke keranjang (dalam Pcs)
        if ($namaSatuan === 'Kodi') {
            // Jika input dalam kodi, ubah ke Pcs
            $qtyDalamPcs = $request->qty * $konversi; // 0.4 kodi = 0.4 * 20 = 8 pcs
        } else if ($namaSatuan === 'Pcs') {
            // Jika input dalam Pcs
            $qtyDalamPcs = $request->qty; // Misal 3 pcs
        } else {
            return redirect()->route('penjualan.index')->with(['error' => 'Satuan tidak ditemukan']);
        }

        // Cek apakah barang sudah ada di keranjang, jika ada hitung total kuantitas
        $cart = session()->get('cart', []);
        $totalQtyDalamPcs = 0;

        foreach ($cart as $item) {
            if ($item['kd_barang'] === $request->kd_barang) {
                $totalQtyDalamPcs += $item['kuantitas']; // Jumlah barang dalam keranjang
            }
        }

        // Tambahkan kuantitas yang baru ke kuantitas total di keranjang
        $totalQtyDalamPcs += $qtyDalamPcs;

        // Cek apakah total kuantitas melebihi stok yang tersedia
        if ($totalQtyDalamPcs > $stokDalamPcsDB) {
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }

        // $cekstok = $barang->stok < $stokDalamPcs;
        // dd($cekstok);
        // if ($barang->stok < $stokDalamPcs) {
        //     return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        // }

        // Ambil data konsumen dari database berdasarkan nama
        $konsumen = Konsumen::where('nama', $request->nama_konsumen)->first();
        if (!$konsumen) {
            return redirect()->back()->with('error', 'Konsumen tidak ditemukan.');
        }

        //masukkan ke session
        session()->put([
            'form_data.metode_pembayaran' => $request->metode_pembayaran,
            'form_data.paymentKredit' => $request->paymentKredit,
            'form_data.nama_konsumen' => $request->input('nama_konsumen'),
            'form_data.alamat' => $konsumen->alamat,
            'form_data.telepon' => $konsumen->telepon,
        ]);

        // Jika ada paymentKredit (DP), simpan ke session
        if ($request->has('paymentKredit') && $request->paymentKredit > 0) {
            session()->put('form_data.bayar', $request->paymentKredit); // Simpan DP ke bayar2
        } else {
            session()->forget('form_data.bayar'); // Hapus jika tidak ada DP
        }

        $cartItem = [
            'kd_barang' => $request->kd_barang,
            'nopenjualan' => $request->no_transaksi,
            'id_konsumen' => session('form_data.nama_konsumen'),
            'id_user' => session('id_user'),
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->paymentKredit > 0 ? 'Belum Lunas' : 'Lunas', // Status berdasarkan DP
            'dp' => $request->paymentKredit, // Simpan DP jika ada
            //detail
            // 'satuan' => session('form_data.satuan'),
            'satuan' => $namaSatuan,
            'harga' => $request->h_jual,
            'kuantitasblade' => $kuantitas,
            'kuantitas' => $stokDalamPcs,
            'subtotal' => $namaSatuan == "Pcs" ? $subtotalpcs : $subtotalkodi,
            'kategori' => $request->kategori,
        ];

        // dd($cartItem['subtotal']);

        // Ambil keranjang dari session atau buat array kosong jika belum ada
        $cart = session()->get('cart', []);

        // dd($cart[0]['satuan']);

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
            'total' => 'required',
            'kembalian' => 'required',
            'bayar' => 'required',
        ]);

        session(['total' => $request->total]);
        session(['kembalian' => $request->kembalian]);
        session(['bayar' => $request->bayar]);

        // Ambil nomor transaksi dari session
        $nopenjualan = session('nopenjualan');

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Pastikan keranjang tidak kosong
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada item untuk diproses.');
        }

        // 1. Menghilangkan format number (Rp dan pemisah ribuan) untuk subtotal dan bayar sebelum perhitungan
        $totalS = str_replace('.', '', str_replace('Rp. ', '', $request->total));
        $bayarS = str_replace('.', '', str_replace('Rp. ', '', $request->bayar));
        $kembalianS = str_replace('.', '', str_replace('Rp. ', '', $request->kembalian));
        $dpS = str_replace(['Rp. ', '.', ' '], '', $cart[0]['dp']);

        $total = intval($totalS);
        $bayar = intval($bayarS);
        $kembalian = intval($kembalianS);
        $dp = intval($dpS);

        // dd([
        //     'total' => $subtotal,
        //     'bayar' => $bayar,
        //     'kembalian' => $kembalian,
        //     'dp' => $dp,
        // ]);

        // Ambil data dari keranjang
        $nama_konsumen = $cart[0]['id_konsumen'];
        //ubah nama_konsumen jadi id_konsumen
        $id_konsumen = DB::table('tkonsumen')->where('nama', $nama_konsumen)->value('id_konsumen');
        $metode_pembayaran = $cart[0]['metode_pembayaran'];
        $status = $cart[0]['status'];
        // $dp = $cart[0]['dp'];

        // Set zona waktu ke Indonesia
        \Carbon\Carbon::setLocale('id');
        $now = \Carbon\Carbon::now('Asia/Jakarta');

        $tanggalLunas = $status === 'Lunas' ? $now : null;
        $jumlahPelunasan = $status === 'Lunas' ? $total : 0;

        $penjualan = Penjualan::create([
            'nopenjualan' => $nopenjualan,
            'id_konsumen' => $id_konsumen,
            'id_user' => session('id_user'),
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'tanggal_pembayaran' => $now,
            'metode_pembayaran' => $metode_pembayaran,
            'status' => $status,
            'dp' => $dp,
            'tanggal_lunas' => $tanggalLunas,
            'jumlah_pelunasan' => $jumlahPelunasan,
        ]);

        foreach ($cart as $item) {
            // Cari ID satuan berdasarkan nama satuan dari keranjang
            $satuan = Satuan::where('nama_satuan', $item['satuan'])->first();
            $barang = Barang::where('kd_barang', $item['kd_barang'])->first();
            $id_satuan = $satuan->id_satuan;
            $harga_beli = $barang->h_beli;

            DetailPenjualan::create([
                'id_user' => session('id_user'),
                'nopenjualan' => $nopenjualan,
                'id_satuan' => $id_satuan,
                'kd_barang' => $item['kd_barang'],
                'h_beli' => $harga_beli,
                'h_jual' => $item['harga'],
                'qty' => $item['kuantitas'],
                'subtotal' => $item['subtotal'],
            ]);

            // Mengurangi stok barang
            if ($barang) {
                $barang->stok -= $item['kuantitas'];
                $barang->save();
            }
        }

        // Hapus nomor transaksi dari session untuk memulai transaksi baru
        session(['nopenjualan' => null]);

        // Bersihkan keranjang setelah transaksi disimpan
        session()->forget(['cart', 'total', 'bayar', 'kembalian', 'form_data']);

        // Redirect atau berikan respons sukses
        return redirect()->route('cetakStruk', [
            'nopenjualan' => $nopenjualan,
        ])->with('success', 'Transaksi Berhasil');
    }

    public function removefromCart($index)
    {
        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Cek apakah index valid
        if (!isset($cart[$index])) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
        }
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

    public function cetakStruk($nopenjualan)
    {
        $transaksi = Penjualan::where('nopenjualan', $nopenjualan)->first();
        $detailTransaksi = DetailPenjualan::where('nopenjualan', $nopenjualan)->get();
        $title = 'Print Transaksi';

        // dd($transaksi, $detailTransaksi);

        return view('transaksi.printpenjualan', compact('transaksi', 'detailTransaksi', 'title'));
    }


    public function show(string $id) {}

    // public function showStruk($nopenjualan)
    // {
    //     // Ambil transaksi berdasarkan nope$nopenjualan
    //     $transaksi = Penjualan::findOrFail($nopenjualan);

    //     // Ambil detail transaksi terkait dengan relasi produk dan ukuran
    //     $detailTransaksi = DetailPenjualan::where('nopenjualan', $nopenjualan)->get();

    //     // Hitung total harga dari detail transaksi
    //     // $totalHarga = $detailTransaksi->sum(function ($detail) {
    //     //     return $detail->jumlah * $detail->produk->harga_jual; // Sesuaikan dengan kolom harga di detail transaksi
    //     // });

    //     // Kirim data ke view struk
    //     return view('users.struk', [
    //         'transaksi' => $transaksi,
    //         'detailTransaksi' => $detailTransaksi,
    //         'totalHarga' => $totalHarga, // Mengirim totalHarga ke view
    //     ]);
    // }
}
