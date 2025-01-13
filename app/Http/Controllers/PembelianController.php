<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Motif;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Ukuran;
use App\Models\Pemasok;
use App\Models\Kategori;
use App\Models\Konsumen;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class PembelianController extends Controller
{
    private function generateKdBarang()
    {
        // // Ambil kode barang terakhir dari tabel
        // $lastBarang = Barang::orderBy('kd_barang', 'desc')->first();

        // // Jika belum ada barang, buat kode pertama
        // if (!$lastBarang) {
        //     return 'KDB0001';
        // }

        // // Ambil angka terakhir dari kd_barang dan tambahkan 1
        // $lastNumber = (int) substr($lastBarang->kd_barang, 3); // Mengambil angka dari 'KDBxxxx'
        // $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi jadi 4 digit

        // // Gabungkan kode prefix dengan angka baru
        // $kodebarang = 'KDB' . $newNumber;

        // session(['kd_barang' => $kodebarang]);
    }
    //
    public function index(Request $request): View
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_toko = session('id_toko_pembelian');
        $id_user = session('id_user_pembelian');
        // dd($id_toko);

        $kunci = $request->input('kunci');
        $itemsDetails = null;
        if ($kunci) {
            $items = session('cart');
            $itemsDetails = isset($items[$kunci]) ? $items[$kunci] : null;
        } else {
            $itemErrorMessage = "Detail item tidak ditemukan. Silakan coba lagi.";
        }

        // Ambil data barang dengan filter berdasarkan id_toko dan pencarian
        $barangs = Barang::with('pemasok', 'satuan', 'kategori')
            ->where('id_toko', $id_toko)
            ->latest()->get();

        $kategoris = Kategori::where('id_toko', $id_toko)
            ->latest()->get();

        $konsumens = Konsumen::where('id_toko', $id_toko)
            ->latest()->get();

        $satuans = Satuan::where('id_toko', $id_toko)
            ->latest()->get();

        $pemasoks = Pemasok::where('id_toko', $id_toko)
            ->latest()->get();

        $motifs = Motif::where('id_toko', $id_toko)
            ->latest()->get();

        $ukurans = Ukuran::where('id_toko', $id_toko)
            ->latest()->get();

        // Cek apakah kd_barang sudah ada di session, jika tidak, ambil kode barang terakhir dari tabel
        if (!session()->has('kd_barang')) {
            $lastBarang = Barang::where('id_toko', $id_toko)
                ->orderBy('kd_barang', 'desc')
                ->first();

            // Jika belum ada barang, buat kode pertama
            $kodebarang = 'KDB0001';
            if ($lastBarang) {
                $lastNumber = (int) substr($lastBarang->kd_barang, 3); // Mengambil angka dari 'KDBxxxx'
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi jadi 4 digit
                $kodebarang = 'KDB' . $newNumber;
            }

            // Simpan kode barang terbaru ke session
            session(['kd_barang' => $kodebarang]);
        }

        // Cek apakah sudah ada nopembelian di session
        if (!session()->has('nopembelian')) {
            // Generate tanggal hari ini
            $today = Carbon::now()->format('Ymd');
            // Mencari nopembelian terakhir
            $lastPembelian = Pembelian::where('nopembelian', 'LIKE', $today . '%')
                ->orderBy('nopembelian', 'desc')
                ->first();

            if ($lastPembelian) {
                // Jika ada transaksi terakhir, ambil nomor urut terakhir
                $lastNoUrut = (int) substr($lastPembelian->nopembelian, 8, 4);
            } else {
                // Jika belum ada transaksi pada hari ini, mulai dari 0
                $lastNoUrut = 0;
            }

            // Nomor urut transaksi berikutnya
            $nextNoUrut = $lastNoUrut + 1;

            // Format nomor transaksi berikutnya dengan 4 digit nomor urut
            $nextNoPembelian = $today . sprintf('%04s', $nextNoUrut);

            // Simpan nopembelian ke session
            session(['nopembelian' => $nextNoPembelian]);
        }

        return view('transaksi.pembelian', [
            'title' => 'Pencatatan Pembelian',
            'konsumens' => $konsumens,
            'pemasoks' => $pemasoks,
            'satuans' => $satuans,
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'motifs' => $motifs,
            'ukurans' => $ukurans,
            'nopembelian' => session('nopembelian'),
            'kd_barang' => session('kd_barang'),
            'itemDetails' => $itemsDetails, // Tambahkan itemDetails ke dalam data yang dikirim ke view
            'itemErrorMessage' => $itemErrorMessage, // Tambahkan pesan kesalahan ke dalam data yang dikirim ke view
        ]);
    }

    // public function hitungHargaJual(Request $request){
    //     $h_beli = $request->input('h_beli');
    // }


    public function addToCart2(Request $request): RedirectResponse
    {
        // Ambil user ID
        $id_toko = session('id_toko_pembelian');

        // try {

        // Validasi input
        $validated =  $request->validate([
            'nopembelian' => 'required',
            'kd_barang' => 'required|string|max:50',
            'id_kategori' => 'required',
            'id_pemasok' => 'required',
            'id_satuan' => 'required',
            'h_beli' => 'required|integer|min:0',
            'warna' => 'required',
            'id_motif' => 'required',
            'id_ukuran' => 'required|string|max:255',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:2048',
            'stokqty' => 'required|numeric|min:0',
        ]);

        if ($request->filled('warnaLainnya')) {
            $validated['warna'] = $request->input('warnaLainnya');
        }
        // dd($request->all());

        //     dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->validator->errors()->all()); // Menampilkan semua kesalahan validasi
        // }

        if ($request->gambar == null) {
            $barang = Barang::where('kd_barang', $request->kd_barang)->first();
            $gambarsudahada = $barang->gambar;

            $kategoris = Kategori::where('id_toko', $id_toko)->where('nama', $request->id_kategori)->first();
            $motifs = Motif::where('id_toko', $id_toko)->where('nama_motif', $request->id_motif)->first();
            $satuans = Satuan::where('id_toko', $id_toko)->where('nama_satuan', $request->id_satuan)->first();
            $pemasoks = Pemasok::where('id_toko', $id_toko)->where('nama', $request->id_pemasok)->first();

            $konversi = $satuans->konversi;

            $kategoriNama = $kategoris->nama;
            $motifNama = $motifs->nama_motif;
            $satuanNama = $satuans->nama_satuan;
            $pemasokNama = $pemasoks->nama;

            $id_kategori = $kategoris->id_kategori;
            $id_motif = $motifs->id_motif;
            $id_satuan = $satuans->id_satuan;
            $id_pemasok = $pemasoks->id_pemasok;

            $result = 'no_image';
        } else {
            $image = $request->file('gambar');
            $image->storeAs('public/barang', $image->hashName());

            // if (!$image) {
            //     return redirect()->route('pembelian.index')->with(['error' => 'Gambar belum dipilih']);
            // }

            $kategoris = Kategori::where('id_toko', $id_toko)->where('id_kategori', $request->id_kategori)->first();
            $motifs = Motif::where('id_toko', $id_toko)->where('id_motif', $request->id_motif)->first();
            $satuans = Satuan::where('id_toko', $id_toko)->where('id_satuan', $request->id_satuan)->first();
            $pemasoks = Pemasok::where('id_toko', $id_toko)->where('id_pemasok', $request->id_pemasok)->first();

            $konversi = $satuans->konversi;

            $kategoriNama = $kategoris->nama;
            $motifNama = $motifs->nama_motif;
            $satuanNama = $satuans->nama_satuan;
            $pemasokNama = $pemasoks->nama;

            $id_kategori = $kategoris->id_kategori;
            $id_motif = $motifs->id_motif;
            $id_satuan = $satuans->id_satuan;
            $id_pemasok = $pemasoks->id_pemasok;

            $result = 'with_image';
        }

        $stokDalamPcs = 0;
        $stokDalamKodi = 0;
        $stok = 0;

        if ($satuanNama === 'Kodi') {
            // Cek apakah stokqty dalam Kodi adalah desimal yang tidak valid
            if ($request->stokqty <= 0) {
                return redirect()->route('pembelian.index')->with(['error' => 'Kuantitas dalam satuan Kodi tidak boleh 0.']);
            } elseif ($request->stokqty < 0.05 && $request->stokqty > 0) {
                return redirect()->route('pembelian.index')->with(['error' => 'Kuantitas dalam satuan Kodi tidak boleh lebih kecil dari 0.05.']);
            }
            // Jika satuan adalah Kodi, konversi stok ke Pcs
            $stokDalamPcs = $request->stokqty * $konversi;
            $stokDalamKodi = $request->stokqty;

            // Hitung subtotal berdasarkan Kodi
            $subtotalkodi = $request->h_beli * $stokDalamKodi; // Harga beli per Kodi
            $kuantitas = $stokDalamKodi;
        } else if ($satuanNama === 'Pcs') {
            if ($request->stokqty <= 0) {
                return redirect()->route('pembelian.index')->with(['error' => 'Kuantitas dalam satuan Pcs tidak boleh 0.']);
            } elseif ($request->stokqty < 1 && $request->stokqty > 0) {
                return redirect()->route('pembelian.index')->with(['error' => 'Kuantitas untuk satuan Pcs tidak boleh dalam bentuk desimal.']);
            }
            $stokDalamPcs = $request->stokqty;
            $stokDalamKodi = $request->stokqty / $konversi;

            $h_beli = $request->h_beli;

            $hargaperpcs = $h_beli / $konversi;
            $subtotalpcs = $hargaperpcs * $stokDalamPcs; // Harga beli per Pcs
            $kuantitas = $stokDalamPcs;
        } else {
            return redirect()->route('pembelian.index')->with(['error' => 'Satuan tidak ditemukan']);
        }

        // Ambil keranjang dari session atau buat array kosong jika belum ada
        $cart2 = session()->get('cart2', []);
        // dd($cart2);
        // Iterasi dengan referensi (&$item) agar perubahan tercermin di array asli
        foreach ($cart2 as &$item) {
            // Tambahkan debug untuk memeriksa kondisi item
            // dd([
            //     'id_kategori_request' => $kategoriNama,
            //     'id_kategori_item' => $item['kategori_nama'],
            //     'id_motif_request' => $motifNama,
            //     'id_motif_item' => $item['motif_nama'],
            //     'warna_request' => $request->filled('warnaLainnya') ? $request->input('warnaLainnya') : $request->warna,
            //     'warna_item' => $item['warna'],
            //     'size_request' => $request->id_ukuran,
            //     'size_item' => $item['size'],
            //     'satuanNama_request' => $satuanNama,
            //     'satuanNama_item' => $item['satuan_nama'],
            // ]);
            if (
                $item['kategori_nama'] == $kategoriNama &&
                $item['motif_nama'] == $motifNama &&
                $item['warna'] == ($request->filled('warnaLainnya') ? $request->input('warnaLainnya') : $request->warna) &&
                $item['size'] == $request->id_ukuran

            ) {
                session()->put('kondisibarangsama_pembelian', $item);
                // Tambahkan debug untuk memeriksa apakah kondisi terpenuhi
                // dd('Kondisi terpenuhi: Item yang sama ditemukan di keranjang.', $item);

                if ($item['satuan_nama'] === 'Pcs' &&  $satuanNama == 'Kodi') {
                    $kodiKePcs = $request->stokqty * $konversi;

                    $item['kuantitas'] += $kodiKePcs;
                    $item['subtotal'] += ($item['h_beli'] / $konversi) * $kodiKePcs;
                } else if ($item['satuan_nama'] === 'Kodi' && $satuanNama == 'Pcs') {
                    if ($request->stokqty < 1 && $request->stokqty > 0) {
                        return redirect()->back()->with('error', 'Kuantitas untuk satuan Pcs tidak boleh dalam bentuk desimal.');
                    }
                    $pcsKeKodi = $request->stokqty / $konversi;

                    $item['kuantitas'] += $pcsKeKodi;
                    $item['subtotal'] += $item['h_beli'] * $pcsKeKodi;
                } else {
                    $item['kuantitas'] += $kuantitas;

                    if ($item['satuan_nama'] === 'Kodi') {
                        $item['subtotal'] += $item['h_beli'] * $kuantitas;
                    } else if ($item['satuan_nama'] === 'Pcs') {
                        $item['subtotal'] += ($item['h_beli'] / $konversi) * $kuantitas;
                    } else {
                        return redirect()->route('pembelian.index')->with(['error' => 'Satuan tidak ditemukan']);
                    }
                }

                session()->put('cart2', $cart2);
                $total = array_sum(array_column($cart2, 'subtotal'));
                session(['subtotal' => $total]);

                return redirect()->back()->with('toastberhasil', 'Jumlah barang berhasil ditambahkan ke keranjang');
            }
        }

        //menghitung HARGA JUAL
        $h_beli = (int)$request->h_beli;

        if ($kategoris->nama == 'Sandal Dewasa Cowo') {
            $persentase_keuntungan = 32.91;
        } elseif ($kategoris->nama == 'Sandal Dewasa Cewe') {
            $persentase_keuntungan = 42.86;
        } elseif ($kategoris->nama == 'Anak Tanggung Cowo') {
            $persentase_keuntungan = 38.46;
        } elseif ($kategoris->nama == 'Anak Tanggung Cewe') {
            $persentase_keuntungan = 34.33;
        } elseif ($kategoris->nama == 'Anak Kecil Cowo') {
            $persentase_keuntungan = 38.46;
        } elseif ($kategoris->nama == 'Anak Kecil Cewe') {
            $persentase_keuntungan = 34.33;
        } else {
            $persentase_keuntungan = 0;
        }

        $h_jual = $h_beli * (1 + ($persentase_keuntungan / 100));
        $h_jual = round($h_jual / 1000) * 1000;

        // dd([
        //     'harga_beli' => $h_beli,
        //     'persentase_keuntungan' => $persentase_keuntungan,
        //     'harga_jual_dihitung' => $h_jual, // Hasil sebelum format
        //     'harga_jual_formatted' => number_format($h_jual, 0, ',', '.'), // Format uang
        // ]);

        // Cek apakah keranjang sudah ada item
        if (count($cart2) > 0) {
            // Ambil id_pemasok dari item pertama di keranjang
            $existingPemasokId = $cart2[0]['id_pemasok'];

            // Cek apakah id_pemasok yang baru sama dengan yang ada di keranjang
            if ($existingPemasokId !== $id_pemasok) {
                return redirect()->back()->withErrors(['pemasok' => 'Anda hanya bisa menambahkan barang dari satu pemasok yang sama.']);
            }
        }

        if ($request->gambar == !null) {
            $lastNumber = (int) substr(session('kd_barang'), 3);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $newKdBarang = 'KDB' . $newNumber;

            session(['kd_barang' => $newKdBarang]);
        }

        $cartItem2 = [
            //pembelian
            'nopembelian' => $request->nopembelian,
            'pemasok_nama' => $pemasokNama,
            'id_pemasok' => $id_pemasok,
            'id_user_pembelian' => session('id_user_pembelian'),
            'id_toko_pembelian' => session('id_toko_pembelian'),
            //detail
            'satuan_nama' => $satuanNama,
            'id_satuan' => $id_satuan,
            'kd_barang' => $request->kd_barang,
            'h_beli' => $request->h_beli,
            'subtotal' => $satuanNama == "Pcs" ? $subtotalpcs : $subtotalkodi,
            //barang
            'kategori_nama' => $kategoriNama,
            'id_kategori' => $id_kategori,
            'h_jual' => $h_jual,
            'kuantitas' => $kuantitas,
            'stokDalamPcs' => $stokDalamPcs,
            'stokDalamKodi' => $stokDalamKodi,
            'warna' => $request->filled('warnaLainnya') ? $request->input('warnaLainnya') : $request->warna,
            'motif_nama' => $motifNama,
            'id_motif' => $id_motif,
            'size' => $request->id_ukuran,
            'result' => $result,
            'gambar' => $request->gambar == null ? $gambarsudahada : $image->hashName(),
        ];

        // dd($cartItem2);

        session()->put('form_data2.pemasok_nama', $pemasokNama);

        session()->put('subtotal', $cartItem2['subtotal']);

        $cart2[] = $cartItem2;

        session()->put('cart2', $cart2);

        $total = array_sum(array_column($cart2, 'subtotal'));
        session(['subtotal' => $total]);

        session()->put('id_pemasokpembelian', $pemasoks->id_pemasok);

        return redirect()->back()->with('toastberhasil', 'Barang berhasil ditambahkan ke keranjang');
    }

    public function getItemDetails(Request $request)
    {
        // Asumsi kan dengan key
        $key = $request->input('key');

        $items = session('cart2');

        $itemDetails = isset($items[$key]) ? $items[$key] : null;

        if ($itemDetails) {
            return response()->json($itemDetails); // Mengembalikan data dalam format JSON
        } else {
            return response()->json(['error' => 'Detail item tidak ditemukan.'], 404); // Mengembalikan pesan kesalahan
        }
    }

    public function store(Request $request): RedirectResponse
    {
        // try {
        $validated =  $request->validate([
            'subtotal' => 'required',
        ]);

        //     dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->validator->errors()->all()); // Menampilkan semua kesalahan validasi
        // }

        \Carbon\Carbon::setLocale('id');
        $now = \Carbon\Carbon::now('Asia/Jakarta');

        $cartItems = session()->get('cart2', []);

        // dd($cartItems);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada data untuk disimpan.');
        }

        DB::beginTransaction();
        try {
            $subtotalS = str_replace('.', '', str_replace('Rp. ', '', $request->subtotal));
            $subtotal = intval($subtotalS);

            // 3. Simpan data ke tabel tpembelian
            $pembelian = new Pembelian();
            $pembelian->nopembelian = $cartItems[0]['nopembelian'];
            $pembelian->id_pemasok = $cartItems[0]['id_pemasok'];
            $pembelian->id_user = $cartItems[0]['id_user_pembelian'];
            $pembelian->id_toko = $cartItems[0]['id_toko_pembelian'];
            $pembelian->total = $subtotal;
            $pembelian->tanggal_pembelian = $now;
            $pembelian->save();

            // Loop setiap item di keranjang untuk diinput ke tiga tabel
            foreach ($cartItems as $item) {
                // Cek apakah barang dengan kombinasi kategori, motif, warna, dan size sudah ada di database
                $existingBarang = Barang::where('kd_barang', (int)$item['kd_barang'])
                    ->where('id_kategori', (int)$item['id_kategori'])
                    ->where('id_motif', (int)$item['id_motif'])
                    ->where('warna', $item['warna'])
                    ->where('size', $item['size'])
                    ->where('id_pemasok', (int)$item['id_pemasok'])
                    ->first();
                // dd($query->toSql(), $query->getBindings());
                if ($existingBarang) {

                    // Konversi stok berdasarkan satuan
                    $stokToAdd = $item['stokDalamPcs'];
                    // dd($stokToAdd);

                    // Jika barang sudah ada, tambahkan stok
                    $existingBarang->stok += $stokToAdd;
                    $existingBarang->save();

                    // Gunakan kd_barang dari barang yang sudah ada
                    $kd_barang = $existingBarang->kd_barang;
                } else {
                    // 1. Simpan data ke tabel tbarang
                    $barang = new Barang();
                    $barang->kd_barang = $item['kd_barang'];
                    $barang->id_pemasok = $item['id_pemasok'];
                    $barang->id_satuan = $item['id_satuan'];
                    $barang->id_kategori = $item['id_kategori'];
                    $barang->id_motif = (int) $item['id_motif'];
                    $barang->id_user = $item['id_user_pembelian'];
                    $barang->id_toko = $item['id_toko_pembelian'];
                    $barang->h_beli = $item['h_beli'];
                    $barang->h_jual = $item['h_jual'];
                    $barang->stok = $item['stokDalamPcs'];
                    $barang->warna = $item['warna'];
                    $barang->size = $item['size'];
                    $barang->gambar = $item['gambar'];
                    $barang->save();
                    // Hitung total transaksi
                    // $total += $item['subtotal'];

                    // Gunakan kd_barang dari barang yang baru diinsert
                    $kd_barang = $barang->kd_barang;
                }

                // 2. Simpan data ke tabel tdetailpembelian
                $detailPembelian = new DetailPembelian();
                $detailPembelian->id_user = $item['id_user_pembelian'];
                $detailPembelian->id_toko = $item['id_toko_pembelian'];
                $detailPembelian->nopembelian = $item['nopembelian'];
                $detailPembelian->id_satuan = $item['id_satuan'];
                $detailPembelian->kd_barang = $kd_barang;
                $detailPembelian->h_beli = $item['h_beli'];
                $detailPembelian->qty = $item['stokDalamPcs'];
                $detailPembelian->subtotal = $item['subtotal'];
                $detailPembelian->save();
            }
            // Commit transaksi jika semuanya sukses
            DB::commit();

            session(['nopembelian' => null]);

            // Hapus keranjang dari session setelah penyimpanan berhasil
            session()->forget('cart2');
            session()->forget('subtotal');
            session()->forget('form_data2');
            session()->forget('id_pemasokpembelian');
            session()->forget('kondisibarangsama_pembelian');
            session()->forget('kd_barang');

            return redirect()->route('laporanpembelian.index')->with('success', 'Pencatatan Pembelian berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function removefromCart2($index)
    {
        $cart2 = session()->get('cart2', []);

        if (!isset($cart2[$index])) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        // Ambil item yang akan dihapus
        $itemToRemove = $cart2[$index];

        // Ambil nama file gambar dari item yang akan dihapus
        $gambar = $itemToRemove['gambar'];
        $result = $itemToRemove['result']; // Ambil status gambar

        if ($gambar == !null && $result == 'with_image') {
            // Hapus gambar dari storage (jika ada)
            if ($gambar) {
                Storage::delete('public/barang/' . $gambar);
            }
        }

        // Ambil subtotal item yang akan dihapus
        $subtotalToRemove = $cart2[$index]['subtotal'];

        // Hapus item berdasarkan index
        unset($cart2[$index]);

        $cart2 = array_values($cart2); // Reindex array

        // Simpan kembali ke session
        session()->put('cart2', $cart2);

        // Hitung total baru dari seluruh subtotal
        $total = array_sum(array_column($cart2, 'subtotal'));

        // Simpan total yang diperbarui ke session
        session(['subtotal' => $total]);


        // Redirect atau kembalikan view
        return redirect()->back()->with('toastberhasil', 'Barang berhasil dihapus dari keranjang');
    }

    public function reset(Request $request)
    {
        // Hapus nopenjualan dari session
        $request->session()->forget('nopembelian');

        $request->session()->forget('id_pemasokpembelian');

        $request->session()->forget('kondisibarangsama_pembelian');

        // $request->session()->forget('kd_barang');

        // Hapus session yang menyimpan data form
        $request->session()->forget('form_data2');


        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil di-reset.');
    }
}
