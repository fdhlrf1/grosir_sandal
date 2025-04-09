<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use App\Models\Barang;
use App\Models\Satuan;


use App\Models\Ukuran;
use App\Models\Pemasok;
use App\Models\Kategori;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    private function generateKdBarang()
    {
        // Ambil kode barang terakhir dari tabel
        $lastBarang = Barang::orderBy('kd_barang', 'desc')->first();

        // Jika belum ada barang, buat kode pertama
        if (!$lastBarang) {
            return 'KDB0001';
        }

        // Ambil angka terakhir dari kd_barang dan tambahkan 1
        $lastNumber = (int) substr($lastBarang->kd_barang, 3); // Mengambil angka dari 'KDBxxxx'
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi jadi 4 digit

        // Gabungkan kode prefix dengan angka baru
        return 'KDB' . $newNumber;
    }

    public function index(Request $request): View
    {
        // Ambil nilai dari input pencarian
        $search = $request->input('search');

        // Ambil id_toko dari session
        $id_toko = session('id_toko');
        $id_user = session('id_user');

        $pemasoks = Pemasok::where('id_toko', $id_toko)->latest()->paginate(5);
        $satuans = Satuan::where('id_toko', $id_toko)->latest()->paginate(10);
        $kategoris = Kategori::where('id_toko', $id_toko)->latest()->paginate(10);
        $motifs = Motif::where('id_toko', $id_toko)->latest()->paginate(10);

        // Query untuk mengambil barang dengan relasi pemasok, satuan, motif ,dan kategori
        // Jika ada input search, tambahkan filter
        // $barangs = Barang::with('pemasok', 'satuan', 'kategori', 'motif')
        //     ->where('id_toko', $id_toko) // Filter berdasarkan id_toko
        //     ->when($search, function ($query, $search) {
        //         return $query->WhereHas('kategori', function ($query) use ($search) {
        //             $query->where('nama', 'like', "%{$search}%");
        //         })->orWhereHas('pemasok', function ($query) use ($search) {
        //             $query->where('nama', 'like', "%{$search}%");
        //         })->orWhereHas('motif', function ($query) use ($search) {
        //             $query->where('nama_motif', 'like', "%{$search}%");
        //         })->orWhereHas('satuan', function ($query) use ($search) {
        //             $query->where('nama_satuan', 'like', "%{$search}%");
        //         })
        //             ->orWhere('warna', 'like', "%{$search}%")
        //             ->orWhere('size', 'like', "%{$search}%");
        //     })->latest()->simplePaginate(5);

        // Query untuk $barangs
        $barangs = Barang::with('pemasok', 'satuan', 'kategori', 'motif')
            ->where('id_toko', $id_toko)
            ->where('stok', '>', 0)
            ->when(
                $search,
                function ($query, $search) {
                    return $query->where(function ($query) use ($search) {
                        $query->whereHas('kategori', function ($query) use ($search) {
                            $query->where('nama', 'like', "%{$search}%");
                        })
                            ->orWhereHas('pemasok', function ($query) use ($search) {
                                $query->where('nama', 'like', "%{$search}%");
                            })
                            ->orWhereHas('motif', function ($query) use ($search) {
                                $query->where('nama_motif', 'like', "%{$search}%");
                            })
                            ->orWhereHas('satuan', function ($query) use ($search) {
                                $query->where(
                                    'nama_satuan',
                                    'like',
                                    "%{$search}%"
                                );
                            })
                            ->orWhere('warna', 'like', "%{$search}%")
                            ->orWhere('size', 'like', "%{$search}%");
                    });
                }
            )
            ->latest()
            ->simplePaginate(5);


        // Kembalikan view dengan data barang dan pencarian

        return view('datautama.d_barang', [
            'title' => 'Data Barang',
            'barangs' => $barangs,
            'pemasoks' => $pemasoks,
            'kategoris' => $kategoris,
            'motifs' => $motifs,
            'satuans' => $satuans,
            'search' => $search,
        ]);
    }

    public function getMotifUkuran(Request $request)
    {
        $kategoriId = $request->get('kategori');

        // Fetch motifs and ukuran based on kategori
        $motifs = Motif::where('id_kategori', $kategoriId)->get();
        $ukuran = Ukuran::where('id_kategori', $kategoriId)->first();

        return response()->json([
            'motifs' => $motifs,
            'ukuran' => $ukuran->ukuran,
        ]);
    }


    public function create() {}

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'id_pemasok' => 'required|exists:tpemasok,id_pemasok',
        //     'id_satuan' => 'required|exists:tsatuan,id_satuan',
        //     'id_kategori' => 'required|exists:tkategori,id_kategori',
        //     'h_beli' => 'required|integer|min:0', // h_beli tidak boleh minus
        //     'h_jual' => 'required|integer|min:0',
        //     'stok' => 'required|integer|min:0',
        //     'warna' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u', // Warna tidak boleh mengandung angka
        //     'motif' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
        //     'size' => 'required|string|max:50',
        //     'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        // ]);

        // // Check if custom size or color is provided
        // if ($request->filled('sizeLainnya')) {
        //     $validated['size'] = $request->input('sizeLainnya');
        // }
        // if ($request->filled('warnaLainnya')) {
        //     $validated['warna'] = $request->input('warnaLainnya');
        // }

        // // Generate kd_barang otomatis
        // $kd_barang = $this->generateKdBarang();

        // $image = $request->file('gambar');
        // $image->storeAs('public/barang', $image->hashName());
        // // dd(session('id_toko'));
        // // Insert data ke database
        // Barang::create([
        //     'kd_barang' => $kd_barang,
        //     'id_pemasok' => $validated['id_pemasok'],
        //     'id_satuan' => $validated['id_satuan'],
        //     'id_kategori' => $validated['id_kategori'],
        //     'id_toko' => session('id_toko'),
        //     'h_beli' =>  $validated['h_beli'],
        //     'h_jual' =>  $validated['h_jual'],
        //     'stok' =>  $validated['stok'],
        //     'warna' => $validated['warna'],
        //     'motif' => $validated['motif'],
        //     'size' => $validated['size'],
        //     'gambar' => $image->hashName(),
        // ]);


        // return redirect()->route('barang.index')->with(['success' => 'Data Berhasil di Insert']);
    }


    public function show(string $id): View
    {
        $barang = Barang::findOrFail($id);
        $pemasoks = Pemasok::all();
        $satuans = Satuan::all();
        $kategoris = Kategori::all();

        return view('datautama.crudbarang.show', compact('barang', 'pemasoks', 'satuans', 'kategoris'));
    }

    public function edit(string $id)
    {
        $id_toko = session('id_toko');

        $barang = Barang::findOrFail($id);
        $pemasoks = Pemasok::where('id_toko', $id_toko)->latest()->paginate(10);
        $satuans = Satuan::where('id_toko', $id_toko)->latest()->paginate(10);
        $kategoris = Kategori::where('id_toko', $id_toko)->latest()->paginate(10);
        $motifs = Motif::where('id_toko', $id_toko)->latest()->paginate(10);
        $title = 'Edit Barang';

        return view('datautama.crudbarang.edit', compact('barang', 'pemasoks', 'satuans', 'kategoris', 'title', 'motifs'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // try {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:tkategori,id_kategori',
            'id_ukuran' => 'required|exists:tukuran,ukuran',
            'id_motif' => 'required|exists:tmotif,id_motif',
            'warna' => 'nullable|string|max:50|regex:/^[\pL\s\-]+$/u',
            'id_satuan' => 'required|exists:tsatuan,id_satuan',
            'id_pemasok' => 'required|exists:tpemasok,id_pemasok',
            'h_beli' => 'required|integer|min:0',
            'h_jual' => 'required|integer|min:0',
            'stok' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // dd($validated);

        // Log::info('Motif ID sebelum update: ' . $validated['id_motif']);

        //     dd($validated);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     dd($e->validator->errors()->all()); // Menampilkan semua kesalahan validasi
        // }

        if ($request->filled('warnaLainnya')) {
            $validated['warna'] = $request->input('warnaLainnya');
        }

        //mengambil barang yang ingin diedit
        $barang = Barang::findOrFail($id);
        // dd($barang);

        $satuan = Satuan::where('id_satuan', $request->id_satuan)->first();
        $namaSatuan = $satuan->nama_satuan;

        if ($namaSatuan === 'Pcs') {
            //pcs
            $stokpcs = $validated['stok'];
        } else if ($namaSatuan === 'Kodi') {
            //kodi
            $stokkodikepcs = $validated['stok'] * $barang->satuan->konversi;
        }

        $stok = ($namaSatuan === 'Pcs') ? $stokpcs : $stokkodikepcs;

        if ($request->hasFile('gambar')) {
            //upload gambar baru
            $image = $request->file('gambar');
            $image->storeAs('public/barang', $image->hashName());

            //hapus gambar lama
            Storage::delete('public/barang/' . $barang->gambar);

            $barang->update([
                'id_pemasok' => $validated['id_pemasok'],
                'id_satuan' => $validated['id_satuan'],
                'id_kategori' => $validated['id_kategori'],
                'id_motif' => $validated['id_motif'],
                'h_beli' =>  $validated['h_beli'],
                'h_jual' =>  $validated['h_jual'],
                'stok' =>  $stok,
                'warna' => $validated['warna'],
                'size' => $validated['id_ukuran'],
                'gambar' => $image->hashName(),
            ]);
        } else {
            //update data product tanpa gambar
            $barang->update([
                'id_pemasok' => $validated['id_pemasok'],
                'id_satuan' => $validated['id_satuan'],
                'id_kategori' => $validated['id_kategori'],
                'id_motif' => $validated['id_motif'],
                'h_beli' =>  $validated['h_beli'],
                'h_jual' =>  $validated['h_jual'],
                'stok' =>  $stok,
                'warna' => $validated['warna'],
                'size' => $validated['id_ukuran'],
            ]);
        }

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function hapusGambar($id): RedirectResponse
    {
        // Cari data barang berdasarkan ID
        $barang = Barang::findOrFail($id);
        dd($barang);
        // Hapus file gambar jika ada
        if ($barang->gambar && Storage::exists('public/barang/' . $barang->gambar)) {
            Storage::delete('public/barang/' . $barang->gambar);
            $barang->gambar = null;
            $barang->save();
        }

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }



    public function destroy($id): RedirectResponse
    {
        $barang = Barang::findOrFail($id);

        Storage::delete('public/barang/' . $barang->gambar);

        $barang->delete();

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus']);
    }
}