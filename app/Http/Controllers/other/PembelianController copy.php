<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Pemasok;
use App\Models\Kategori;
use App\Models\Konsumen;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use Illuminate\Http\RedirectResponse;


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

        // Ambil id_user dari session
        $id_user = session('id_user');

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

        $kategoris = Kategori::where('id_user', $id_user)
            ->latest()
            ->paginate(10);

        $konsumens = Konsumen::where('id_user', $id_user)
            ->latest()
            ->paginate(10);

        $satuans = Satuan::where('id_user', $id_user)
            ->latest()
            ->paginate(10);

        $pemasoks = Pemasok::where('id_user', $id_user)
            ->latest()
            ->paginate(10);


        // Ambil kode barang terakhir dari tabel
        $lastBarang = Barang::orderBy('kd_barang', 'desc')->first();
        // Jika belum ada barang, buat kode pertama
        $kodebarang = 'KDB0001';
        if ($lastBarang) {
            # code...
            // Ambil angka terakhir dari kd_barang dan tambahkan 1
            $lastNumber = (int) substr($lastBarang->kd_barang, 3); // Mengambil angka dari 'KDBxxxx'
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi jadi 4 digit
            // Gabungkan kode prefix dengan angka baru
            $kodebarang = 'KDB' . $newNumber;
        }

        session(['kd_barang' => $kodebarang]);


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
            'title' => 'Data Konsumen',
            'konsumens' => $konsumens,
            'pemasoks' => $pemasoks,
            'satuans' => $satuans,
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'nopembelian' => session('nopembelian'),
            'kd_barang' => session('kd_barang'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        // dd('Masuk ke fungsi store');
        // try {
        $validated = $request->validate([
            'nopembelian' => 'required',
            'kd_barang' => 'required|string|max:50',
            'id_kategori' => 'required|exists:tkategori,id_kategori',
            'id_pemasok' => 'required|exists:tpemasok,id_pemasok',
            'id_satuan' => 'required|exists:tsatuan,id_satuan',
            'h_beli' => 'required|integer|min:0',
            'h_jual' => 'required|integer|min:0',
            // 'stok' => 'required|integer|min:0',
            'warna' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'motif' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'size' => 'required|string|max:50',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'stokqty' => 'required|integer|min:0',
            'metode_pembayaran' => 'required',
            'total' => 'required|numeric|min:0',
            'kembalian' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'paymentKredit' => ['nullable', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->metode_pembayaran === 'kredit' && is_null($value)) {
                    $fail('DP harus diisi jika metode pembayaran adalah kredit.');
                }
            }],
        ]);
        //Melakukan dd untuk memeriksa data yang telah divalidasi
        // dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->validator->errors()->all()); // Menampilkan semua kesalahan validasi
        // }

        // Ambil nomor transaksi dari session
        $nopembelian = session('nopembelian');

        // Set zona waktu ke Indonesia
        \Carbon\Carbon::setLocale('id'); // (Opsional) jika Anda ingin menggunakan locale Indonesia
        $now = \Carbon\Carbon::now('Asia/Jakarta'); // Ambil waktu sekarang dengan zona waktu Jakart

        // Penentuan status dan tanggal lunas
        $status = $request->paymentKredit > 0 ? 'Belum Lunas' : 'Lunas';
        $tanggalLunas = $status === 'Lunas' ? $now : null;
        $jumlahPelunasan = $status === 'Lunas' ? $request->bayar : 0;


        // Check if custom size or color is provided
        if ($request->filled('sizeLainnya')) {
            $validated['size'] = $request->input('sizeLainnya');
        }
        if ($request->filled('warnaLainnya')) {
            $validated['warna'] = $request->input('warnaLainnya');
        }

        // Generate kd_barang otomatis
        // $kd_barang = $this->generateKdBarang();

        $kodebarang = session('kd_barang');

        $image = $request->file('gambar');
        $image->storeAs('public/barang', $image->hashName());

        // Insert data ke database
        $databarang = [
            'kd_barang' => $kodebarang,
            'id_pemasok' => (int) $validated['id_pemasok'],
            'id_satuan' => (int) $validated['id_satuan'],
            'id_kategori' => (int) $validated['id_kategori'],
            'id_user' => session('id_user'),
            'h_beli' => (int)  $validated['h_beli'],
            'h_jual' => (int)  $validated['h_jual'],
            'stok' => (int)  $validated['stokqty'],
            'warna' => $validated['warna'],
            'motif' => $validated['motif'],
            'size' => $validated['size'],
            'gambar' => $image->hashName(),
        ];


        // dd($databarang);


        // Insert data ke tabel tpembelian
        $pembelian = [
            'nopembelian' => $nopembelian,
            'id_pemasok' => (int) $validated['id_pemasok'],
            'id_user' => session('id_user'), // Asumsi user dari session
            'total' => (int) $validated['total'],
            'bayar' => (int) $validated['bayar'],
            'kembalian' => (int) $validated['kembalian'],
            'tanggal_pembelian' => $now,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status' => $status,
            'dp' => (int) $request->paymentKredit,
            'tanggal_lunas' => $tanggalLunas,
            'jumlah_pelunasan' => (int) $jumlahPelunasan
        ];

        dd($pembelian);

        // Pastikan kd_barang adalah array
        if (!is_array($validated['kd_barang'])) {
            // Jika kd_barang adalah string, konversi menjadi array
            $validated['kd_barang'] = explode(',', $validated['kd_barang']); // Misal, pisahkan dengan koma
        }
        // dd($validated['kd_barang']);

        // Insert data ke tabel tdetailpembelian untuk setiap barang yang dibeli
        foreach ($validated['kd_barang'] as $key => $kd_barang) {
            $detaildata = [
                'nopembelian' => $nopembelian, // Relasi ke tpembelian
                'id_user' => session('id_user'), // User yang sama dengan pembelian
                'id_satuan' => (int) $validated['id_satuan'][$key], // Satuan untuk tiap barang
                'kd_barang' => $kd_barang,
                'h_beli' => (int) $validated['h_beli'][$key],
                'qty' => (int) $validated['stokqty'][$key],
                'subtotal' => (int) $validated['h_beli'][$key] * (int) $validated['stokqty'][$key], // Subtotal = harga beli * qty
            ];
        }
        dd($detaildata);

        return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}
