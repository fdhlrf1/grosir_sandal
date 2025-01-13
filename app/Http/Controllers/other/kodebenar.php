<?php
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

        // Ambil kategori, konsumen, satuan, dan pemasok berdasarkan id_user
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

        // Cek apakah kd_barang sudah ada di session, jika tidak, ambil kode barang terakhir dari tabel
        if (!session()->has('kd_barang')) {
            $lastBarang = Barang::where('id_user', $id_user)
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
            $today = Carbon::now()->format('Ymd');
            $lastPembelian = Pembelian::where('nopembelian', 'LIKE', $today . '%')
                ->orderBy('nopembelian', 'desc')
                ->first();

            $lastNoUrut = $lastPembelian ? (int) substr($lastPembelian->nopembelian, 8, 4) : 0;
            $nextNoUrut = $lastNoUrut + 1;
            $nextNoPembelian = $today . sprintf('%04s', $nextNoUrut);

            session(['nopembelian' => $nextNoPembelian]);
        }

        // Render view dengan data yang dibutuhkan
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


    public function addToCart(Request $request): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'nopembelian' => 'required',
            'kd_barang' => 'required|string|max:50',
            'id_kategori' => 'required|exists:tkategori,id_kategori',
            'id_pemasok' => 'required|exists:tpemasok,id_pemasok',
            'id_satuan' => 'required|exists:tsatuan,id_satuan',
            'h_beli' => 'required|integer|min:0',
            'h_jual' => 'required|integer|min:0',
            'warna' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'motif' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'size' => 'required|string|max:50',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'stokqty' => 'required|integer|min:0',
            'metode_pembayaran' => 'required',
            'paymentKredit' => ['nullable', 'numeric', 'min:0', function ($attribute, $value, $fail) use ($request) {
                if ($request->metode_pembayaran === 'kredit' && is_null($value)) {
                    $fail('DP harus diisi jika metode pembayaran adalah kredit.');
                }
            }],
        ]);

        // Simpan gambar
        $image = $request->file('gambar');
        $image->storeAs('public/barang', $image->hashName());

        // Masukkan ke session
        session()->put([
            'form_data.metode_pembayaran' => $request->metode_pembayaran,
            'form_data.paymentKredit' => $request->paymentKredit,
        ]);

        // Data keranjang yang akan ditambahkan
        $cartItem = [
            'nopembelian' => $request->nopembelian,
            'id_pemasok' => $request->id_pemasok,
            'id_user' => session('id_user'),
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => $request->paymentKredit > 0 ? 'Belum Lunas' : 'Lunas',
            'dp' => $request->paymentKredit,
            'id_satuan' => $request->id_satuan,
            'kd_barang' => $request->kd_barang,
            'h_beli' => $request->h_beli,
            'subtotal' => $request->h_beli * $request->stokqty,
            'id_kategori' => $request->id_kategori,
            'h_jual' => $request->h_jual,
            'stok' => $request->stokqty,
            'warna' => $request->warna,
            'motif' => $request->motif,
            'size' => $request->size,
            'gambar' => $image->hashName(),
        ];

        // Ambil keranjang dari session atau buat array kosong jika belum ada
        $cart = session()->get('cart', []);

        // Tambahkan item ke dalam keranjang
        $cart[] = $cartItem;

        // Simpan kembali keranjang ke session
        session()->put('cart', $cart);

        // Tambahkan logika untuk menaikkan kode barang
        $lastNumber = (int) substr(session('kd_barang'), 3); // Mengambil angka terakhir dari session kd_barang
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambah 1 dan format 4 digit
        $newKdBarang = 'KDB' . $newNumber;

        // Update session dengan kode barang terbaru
        session(['kd_barang' => $newKdBarang]);

        // Redirect atau kembalikan view
        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang');
    }

?>