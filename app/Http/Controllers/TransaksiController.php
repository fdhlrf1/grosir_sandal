<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Konsumen;
use App\Models\Penjualan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_toko = session('id_toko_penjualan');
        $id_user = session('id_user_penjualan');

        // Simpan status modal ke session
        $showModal = $request->has('show_modal');

        // Ambil data barang dengan filter berdasarkan id_toko dan pencarian
        $barangs = Barang::with('pemasok', 'satuan', 'kategori', 'motif')
            ->where('id_toko', $id_toko)
            ->where('stok', '>', 0)
            ->latest()
            ->paginate(10);

        $kategoris = Kategori::where('id_toko', $id_toko)
            ->latest()
            ->paginate(10);

        $konsumens = Konsumen::where('id_toko', $id_toko)
            ->latest()
            ->paginate(10);

        $satuans = Satuan::where('id_toko', $id_toko)
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
            'title' => 'Penjualan',
            'konsumens' => $konsumens,
            'barangs' => $barangs,
            'satuans' => $satuans,
            'kategoris' => $kategoris,
            'showModal' => $showModal,
            'nopenjualan' => session('nopenjualan'),
        ]);
    }

    // public function showtoast()
    // {
    //     // Trigger toast SweetAlert
    //     return redirect()->back()->with('toastberhasil', 'Data berhasil disimpan!');
    // }

    public function addToCart(Request $request): RedirectResponse
    {
        //try {

        // Validasi input
        $validated =  $request->validate([
            'kd_barang' => 'required',
            'no_transaksi' => 'required',
            'nama_konsumen' => 'required',
            'kd_barang' => 'required|string|max:50',
            'kategori' => 'required',
            'motif' => 'required',
            'stok' => 'required',
            'warna' => 'required',
            'id_ukuran' => 'required',
            'h_jual' => 'required|numeric',
            'qty' => 'required|numeric|min:0',
            'id_satuan' => 'required|string|numeric|exists:tsatuan,id_satuan',
            // 'metode_pembayaran' => 'required',
            // 'paymentKredit' => ['nullable', 'string', 'regex:/^Rp\. [0-9]{1,3}(?:\.[0-9]{3})*$/', function ($attribute, $value, $fail) use ($request) {
            //     if ($request->metode_pembayaran === 'kredit' && (is_null($value) || $value === '')) {
            //         $fail('DP harus diisi jika metode pembayaran adalah kredit.');
            //     }
            // }],
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
            // Cek apakah qty dalam Kodi adalah desimal yang tidak valid
            if ($request->qty <= 0) {
                return redirect()->route('penjualan.index')->with(['error' => 'Kuantitas dalam satuan Kodi tidak boleh 0.']);
            } elseif ($request->qty < 0.05 && $request->qty > 0) {
                return redirect()->route('penjualan.index')->with(['error' => 'Kuantitas dalam satuan Kodi tidak boleh lebih kecil dari 0.05.']);
            }

            $stokDalamPcs = $request->qty * $konversi;
            $stokDalamKodi = $request->qty;

            $subtotalkodi = $request->h_jual * $stokDalamKodi; // Harga jual per Kodi
            $kuantitas = $stokDalamKodi;
            $kuantitaspcs = $stokDalamPcs;
            $qtypembanding = $stokDalamPcs;
        } else if ($namaSatuan === 'Pcs') {
            if ($request->qty <= 0) {
                return redirect()->route('penjualan.index')->with(['error' => 'Kuantitas dalam satuan Pcs tidak boleh 0.']);
            } elseif ($request->qty < 1 && $request->qty > 0) {
                return redirect()->route('penjualan.index')->with(['error' => 'Kuantitas untuk satuan Pcs tidak boleh dalam bentuk desimal.']);
            }
            $stokDalamPcs = $request->qty;
            $stokDalamKodi = $request->qty / $konversi;

            $h_jual = $request->h_jual;

            $hargaperpcs = $h_jual / $konversi;
            $subtotalpcs = $hargaperpcs * $stokDalamPcs;
            $kuantitas = $stokDalamPcs;
            $qtypembanding = $stokDalamPcs;
        } else {
            return redirect()->route('penjualan.index')->with(['error' => 'Satuan tidak ditemukan']);
        }

        // Cek stok barang
        $barang = Barang::where('kd_barang', $request->kd_barang)->first();
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        // Cek stok dalam satuan Kodi dan Pcs
        $stokDalamPcsDB = $barang->stok;

        if ($qtypembanding > $stokDalamPcsDB) {
            // dd(['Kondisi ini terpenuhi barang melebihi', $qtypembanding, $stokDalamPcsDB]);
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }

        // Hitung jumlah kuantitas yang akan ditambahkan ke keranjang (dalam Pcs)
        // if ($namaSatuan === 'Kodi') {
        //     // Jika input dalam kodi, ubah ke Pcs
        //     $qtyDalamPcs = $request->qty * $konversi; // 0.4 kodi = 0.4 * 20 = 8 pcs
        // } else if ($namaSatuan === 'Pcs') {
        //     // Jika input dalam Pcs
        //     $qtyDalamPcs = $request->qty; // Misal 3 pcs
        // } else {
        //     return redirect()->route('penjualan.index')->with(['error' => 'Satuan tidak ditemukan']);
        // }

        // Cek apakah barang sudah ada di keranjang, jika ada hitung total kuantitas
        $cart = session()->get('cart', []);

        $totalakhir = 0;
        // $totalQtyDalamPcs = 0;
        foreach ($cart as &$item) {
            if ($item['kd_barang'] == $request->kd_barang) {
                // session()->put('kondisibarangsama_penjualan', $item);
                if ($item['satuan'] === 'Pcs' &&  $namaSatuan == 'Kodi') {
                    $kodiKePcs = $request->qty * $konversi;

                    $totalQtyDalamPcs = $item['kuantitasblade'] += $kodiKePcs;
                    $totalakhir += $totalQtyDalamPcs;
                    $item['subtotal'] += ($item['harga'] / $konversi) * $kodiKePcs;
                    if ($totalakhir > $stokDalamPcsDB) {
                        return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
                    }
                    // dd($totalQtyDalamPcs);
                    // dd([

                    //     'kondisi satuan Awal = PCS, satuan Dipilih = KODI ini terpenuhi',
                    //     'totalqtydalampcs' => $totalQtyDalamPcs,
                    // ]);

                } else if ($item['satuan'] === 'Kodi' && $namaSatuan == 'Pcs') {
                    // Cek apakah kuantitas merupakan nilai desimal
                    if ($request->qty < 1 && $request->qty > 0) {
                        return redirect()->back()->with('error', 'Kuantitas untuk satuan Pcs tidak boleh dalam bentuk desimal.');
                    }
                    $pcsKeKodi = $request->qty / $konversi;

                    $kuantitaspcs1 = $item['kuantitasblade'] * $konversi;
                    $kuantitaspcs = (int)$kuantitas;
                    $akhirkuantitaspcs = $kuantitaspcs1 + $kuantitaspcs;

                    $item['kuantitasblade'] += $pcsKeKodi;
                    $totalQtyDalamPcs = $akhirkuantitaspcs;
                    $totalakhir += $totalQtyDalamPcs;
                    $item['subtotal'] += $item['harga'] * $pcsKeKodi;
                    if ($totalakhir > $stokDalamPcsDB) {
                        return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
                    }
                    // dd([
                    //     'kondisi satuan Awal = KODI, satuan Dipilih = PCS ini terpenuhi',
                    //     'totalqtydalampcs' => $totalQtyDalamPcs,
                    // ]);

                } else {
                    if ($item['satuan'] === 'Kodi') {
                        $kuantitaspcs1 = $item['kuantitasblade'] * $konversi;
                        $kuantitaspcs = $kuantitas * $konversi;
                        $akhirkuantitaspcs = $kuantitaspcs1 + $kuantitaspcs;
                        // dd($akhirkuantitaspcs);
                        $totalQtyDalamPcs = $akhirkuantitaspcs;

                        $item['kuantitasblade'] += $kuantitas;
                        // dd($totalQtyDalamPcs);
                        $item['subtotal'] += $item['harga'] * $kuantitas;
                        $totalakhir += $totalQtyDalamPcs;
                        if ($totalakhir > $stokDalamPcsDB) {
                            // dd(['Kondisi ini terpenuhi barang melebihi untuk satuan KODI', $totalakhir, $stokDalamPcsDB]);
                            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
                        }
                        // dd('kondisi tidak terpenuhi');

                        // dd([
                        //     $totalakhir,
                        //     $stokDalamPcsDB,
                        //     'satuan sama nya KODI'
                        // ]);
                        // dd([
                        //     'kondisi SAMA ini terpenuhi IF SATUAN KODI',
                        //     'totalqtydalampcs' => $totalQtyDalamPcs,
                        // ]);
                    } else if ($item['satuan'] === 'Pcs') {

                        // $totalawal = (int)$request->qty;
                        $totalQtyDalamPcs = $item['kuantitasblade'] += $kuantitas;
                        $item['subtotal'] += ($item['harga'] / $konversi) * $kuantitas;
                        $totalakhir += $totalQtyDalamPcs;
                        if ($totalakhir > $stokDalamPcsDB) {
                            // dd([
                            //     'Kondisi ini terpenuhi barang melebihi untuk satuan PCS',
                            //     $totalakhir,
                            //     $stokDalamPcsDB
                            // ]);
                            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
                        }
                        // dd('kondisi tidak terpenuhi');

                        // if ($totalakhir > $stokDalamPcsDB) {
                        //     dd([
                        //         'Kondisi ini terpenuhi barang melebihi untuk satuan PCS',
                        //         $totalakhir,
                        //         $stokDalamPcsDB
                        //     ]);
                        //     return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
                        // } else {
                        //     dd('kondisi tidak terpenuhi');
                        // }
                        // dd([
                        //     $totalakhir,
                        //     $stokDalamPcsDB,
                        //     'satuan sama nya PCS',
                        // ]);
                        // dd([
                        //     'kondisi SAMA ini terpenuhi IF SATUAN PCS',
                        //     'totalqtydalampcs' => $totalQtyDalamPcs,
                        // ]);
                    } else {
                        return redirect()->route('pembelian.index')->with(['error' => 'Satuan tidak ditemukan']);
                    }
                }
                session()->put('cart', $cart);

                return redirect()->back()->with('toastberhasil', 'Jumlah barang berhasil ditambahkan ke keranjang');
            }
        }

        // dd($kuantitas);


        // $totalQtyDalamPcs = 0;

        // foreach ($cart as $item) {
        //     if ($item['kd_barang'] === $request->kd_barang) {
        //         $totalQtyDalamPcs += $item['kuantitas']; // Jumlah barang dalam keranjang
        //     }
        // }

        // Tambahkan kuantitas yang baru ke kuantitas total di keranjang
        // $totalQtyDalamPcs += $qtyDalamPcs;

        // Cek apakah total kuantitas melebihi stok yang tersedia
        // if ($totalQtyDalamPcs > $stokDalamPcsDB) {
        //     dd('Kondisi ini terpenuhi barang melebihi');
        //     return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        // }

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
            'id_user_penjualan' => session('id_user_penjualan'),
            'id_toko_penjualan' => session('id_toko_penjualan'),
            'metode_pembayaran' => $request->metode_pembayaran,
            // 'status' => $request->paymentKredit > 0 ? 'Belum Lunas' : 'Lunas', // Status berdasarkan DP
            // 'dp' => $request->paymentKredit, // Simpan DP jika ada
            //detail
            // 'satuan' => session('form_data.satuan'),
            'kategori' => $request->kategori,
            'warna' => $request->warna,
            'size' => $request->id_ukuran,
            'satuan' => $namaSatuan,
            'harga' => $request->h_jual,
            'kuantitasblade' => $kuantitas,
            // 'kuantitas' => $stokDalamPcs,
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
        return redirect()->back()->with('toastberhasil', 'Barang berhasil ditambahkan ke keranjang');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'total' => 'required',
            'kembalian' => 'required',
            'bayar' => 'required',
            'sisa' => 'required',
            // 'tanggal_jatuh_tempo',
        ]);

        // dd($request->all());

        session(['total' => $request->total]);
        session(['kembalian' => $request->kembalian]);
        session(['bayar' => $request->bayar]);
        session(['sisa' => $request->sisa]);
        // session(['tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo]);

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
        $sisaS = str_replace('.', '', str_replace('Rp. ', '', $request->sisa));
        // $dpS = str_replace(['Rp. ', '.', ' '], '', $cart[0]['dp']);

        $total = intval($totalS);
        $bayar = intval($bayarS);
        $kembalian = intval($kembalianS);
        $sisa = intval($sisaS);
        // $dp = intval($dpS);

        if ($bayar < $total) {
            $bayartunaiorkredit = $bayar;
        } else {
            $bayartunaiorkredit = 0;
        }

        // dd($bayar);
        // dd([
        //     'total' => $total,
        //     'bayar' => $bayar,
        //     'kembalian' => $kembalian,
        //     'sisa' => $sisa,
        // ]);

        // Ambil data dari keranjang
        $nama_konsumen = $cart[0]['id_konsumen'];
        //ubah nama_konsumen jadi id_konsumen
        $id_konsumen = DB::table('tkonsumen')->where('nama', $nama_konsumen)->value('id_konsumen');
        // TANGGAL PEMBAYARAN
        \Carbon\Carbon::setLocale('id');
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $tanggal_pembayaran = $now;

        // dd($now);

        if ($sisa > 0) {
            // dd('kondisi ini terpenuhi, kredit');
            $metode_pembayaran = 'Kredit';
            $status = 'Belum Lunas';
            // $tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;
            $tanggal_jatuh_tempo = $tanggal_pembayaran->copy()->addDays(7);
            // dd([
            //     'metode pmby' => $metode_pembayaran,
            //     'status' => $status,
            //     'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            // ]);
        } else {
            // dd('kondisi ini terpenuhi, tunai');
            $metode_pembayaran = 'Tunai';
            $status = 'Lunas';
            $tanggal_jatuh_tempo = null;
            // dd([
            //     'metode pmby' => $metode_pembayaran,
            //     'status' => $status,
            //     'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            // ]);
        }

        // $metode_pembayaran = $sisa > 0 ? 'Kredit' : 'Tunai';
        // $status = $sisa > 0 ? 'Belum Lunas' : 'Lunas';
        // $dp = $cart[0]['dp'];

        $tanggalLunas = $status === 'Lunas' ? null : null;
        $jumlahPelunasan = $status === 'Lunas' ? 0 : 0;
        $dp = $status === 'Lunas' ? 0 : $bayar;

        // dd([
        //     'nopenjualan' => $nopenjualan,
        //     'id_konsumen' => $id_konsumen,
        //     'id_toko' => session('id_toko_penjualan'),
        //     'total' => $total,
        //     'bayar' => $bayar,
        //     'kembalian' => $kembalian,
        //     'tanggal_pembayaran' => $now,
        //     'metode_pembayaran' => $metode_pembayaran,
        //     'status' => $status,
        //     'dp' => $bayartunaiorkredit,
        //     'sisa' => $sisa,
        //     'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
        //     'tanggal_lunas' => $tanggalLunas,
        //     'jumlah_pelunasan' => $jumlahPelunasan,
        // ]);
        $penjualan = Penjualan::create([
            'nopenjualan' => $nopenjualan,
            'id_konsumen' => $id_konsumen,
            'id_user' => session('id_user_penjualan'),
            'id_toko' => session('id_toko_penjualan'),
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'tanggal_pembayaran' => $tanggal_pembayaran,
            'metode_pembayaran' => $metode_pembayaran,
            'status' => $status,
            'dp' => $dp,
            'sisa' => $sisa,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'tanggal_lunas' => $tanggalLunas,
            'jumlah_pelunasan' => $jumlahPelunasan,
        ]);

        foreach ($cart as $item) {
            // Cari ID satuan berdasarkan nama satuan dari keranjang
            $satuan = Satuan::where('nama_satuan', $item['satuan'])->first();
            $barang = Barang::where('kd_barang', $item['kd_barang'])->first();
            $id_satuan = $satuan->id_satuan;
            $harga_beli = $barang->h_beli;
            $kuantitasasli = $item['kuantitasblade'];

            // dd($kuantitasasli);

            $kuantitasFinal = $kuantitasasli * 20;

            // dd($kuantitasFinal);

            // dd($item['satuan']);
            if ($item['satuan'] == 'Kodi') {
                $kuantitas = $kuantitasFinal;
            } else if ($item['satuan'] == 'Pcs') {
                $kuantitas = $item['kuantitasblade'];
            }
            // dd($kuantitasasli);
            // dd($kuantitas);
            // dd([
            //     'id_toko' => session('id_toko_penjualan'),
            //     'nopenjualan' => $nopenjualan,
            //     'id_satuan' => $id_satuan,
            //     'kd_barang' => $item['kd_barang'],
            //     'h_beli' => $harga_beli,
            //     'h_jual' => $item['harga'],
            //     'qty' => $kuantitas,
            //     'subtotal' => $item['subtotal'],
            // ]);
            DetailPenjualan::create([
                'id_user' => session('id_user_penjualan'),
                'id_toko' => session('id_toko_penjualan'),
                'nopenjualan' => $nopenjualan,
                'id_satuan' => $id_satuan,
                'kd_barang' => $item['kd_barang'],
                'h_beli' => $harga_beli,
                'h_jual' => $item['harga'],
                'qty' => $kuantitas,
                'subtotal' => $item['subtotal'],
            ]);

            // Mengurangi stok barang
            if ($barang) {
                $barang->stok -= $kuantitas;
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
        ]);
    }

    public function backToLapPenjualan()
    {
        return redirect()->route('laporanpenjualan.index')->with('success', 'Transaksi Berhasil');
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
        return redirect()->back()->with('toastberhasil', 'Barang berhasil dihapus dari keranjang');
    }

    public function reset(Request $request)
    {
        $request->session()->forget('cart');

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
