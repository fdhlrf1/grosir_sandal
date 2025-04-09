<x-layout>
    <style>
        .readonly-select {
            pointer-events: none;
            /* Mematikan interaksi pengguna */
            background-color: #e5e7eb;
            /* Warna abu-abu */
        }

        .readonly-button {
            pointer-events: none;
            /* Mematikan interaksi pengguna */
            background-color: #cbd5e0;
            /* Mengubah warna tombol menjadi abu-abu */
            color: #a0aec0;
            /* Mengubah warna teks menjadi lebih pudar */
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>


    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Pembelian</span>
    </h1>

    @include('transaksi.modal-detail-pembelian')
    @include('transaksi.modal-pilih-pembelian')


    <!-- UI Formulir untuk Pembelian -->
    <!-- Nomor Pembelian -->
    <form action="/add-to-cart2" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- <div class="grid grid-cols-2 gap-4 mb-4"> --}}
        <!-- Input Nomor Pembelian -->
        <div class="mb-4">
            <label for="nopembelian" class="block font-medium text-gray-700 text-md">Nomor Pembelian:</label>
            <input type="text" name="nopembelian" id="nopembelian" maxlength="100"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('nopembelian') border-red-500 @enderror"
                value="{{ session('nopembelian', $nopembelian) }}" readonly>
            @error('nopembelian')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            {{-- <label for="kd_barang" class="block font-medium text-gray-700 text-md">Kode Barang:</label> --}}
            <input type="hidden" name="kd_barang" id="kd_barang" maxlength="100"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('kd_barang') border-red-500 @enderror"
                value="{{ session('kd_barang') }}" readonly>
            @error('kd_barang')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <h1 class="pb-2 mb-4 text-xl font-semibold text-gray-800 border-b border-gray-300">
            <span class="text-blue-600">Kelola Barang Anda</span>
            <span class="block mt-2 text-base italic text-red-500">*Pilih barang dari daftar atau tambahkan
                baru.</span>
        </h1>
        @php
            // Tentukan apakah pemasok sudah dipilih atau menambahkan barang yang sama
            $pemasokDipilih = session()->has('id_pemasok');
            $barangSamaDipilih = session()->has('kondisibarangsama_pembelian');
        @endphp


        <!-- Tombol Pilih Barang -->
        <div class="mb-2">
            <button type="button" id="cariBarangButton2"
                class="px-4 py-2 font-bold text-white transition-colors bg-blue-500 rounded hover:bg-blue-600">Pilih
                Barang</button>
        </div>

        <!-- Metode Pembayaran -->
        {{-- <div class="mb-4">
            <label class="block font-medium text-gray-700 text-md">Metode Pembayaran</label>
            <div class="flex items-center mt-2">

                <input type="hidden" name="metode_pembayaran"
                    value="{{ old('metode_pembayaran', session('form_data2.metode_pembayaran')) }}">

                <input type="radio" id="tunai" name="metode_pembayaran" value="Tunai"
                    class="form-radio @error('metode_pembayaran') border-red-500 @enderror"
                    {{ old('metode_pembayaran', session('form_data2.metode_pembayaran')) === 'Tunai' ? 'checked' : '' }}
                    @if (old('metode_pembayaran', session('form_data2.metode_pembayaran'))) disabled @endif>
                <label for="tunai" class="ml-2 text-gray-600">Tunai</label>
            </div>
            <div class="flex items-center mt-2">
                <input type="radio" id="kredit" name="metode_pembayaran" value="Kredit"
                    class="form-radio @error('metode_pembayaran') border-red-500 @enderror"
                    {{ old('metode_pembayaran', session('form_data2.metode_pembayaran')) === 'Kredit' ? 'checked' : '' }}
                    @if (old('metode_pembayaran', session('form_data2.metode_pembayaran'))) disabled @endif>
                <label for="kredit" class="ml-2 text-gray-600">Kredit</label>
            </div>

            <div id="paymentKreditDiv" class="hidden mt-3">
                <label for="paymentKredit" class="block text-sm font-medium text-gray-700">Masukkan Nominal
                    DP:</label>
                <input type="text" name="paymentKredit" id="paymentKredit"
                    value="{{ is_numeric(old('paymentKredit', session('form_data2.paymentKredit'))) ? number_format((float) old('paymentKredit', session('form_data2.paymentKredit')), 0, ',', '.') : old('paymentKredit', session('form_data2.paymentKredit')) }}"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('paymentKredit') border-red-500 @enderror
                    @if (old('metode_pembayaran', session('form_data2.metode_pembayaran'))) bg-gray-200 text-gray-700 cursor-default focus:ring-0 focus:border-gray-300 @endif"
                    @if (old('metode_pembayaran', session('form_data2.metode_pembayaran'))) readonly @endif>
            </div>

            @error('metode_pembayaran')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div> --}}

        <h1 class="pb-2 mb-4 text-lg font-semibold text-gray-800 border-b border-gray-300">
        </h1>


        <h1 class="pb-3 mb-4 text-xl font-semibold text-center text-blue-500 border-b border-gray-300">
            Tambah baru barang
        </h1>


        <!-- Form Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- Tampilkan pesan sukses jika ada -->
            {{-- @if (session()->has('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded"
                role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif --}}

            <!-- Pemasok -->
            <div>
                <label for="id_pemasok" class="block font-medium text-gray-700 text-md">Pemasok:</label>
                <select name="id_pemasok" id="id_pemasok"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('pemasok') border-red-500 @enderror {{ $pemasokDipilih || $barangSamaDipilih ? 'bg-gray-200 readonly-select' : '' }}"
                    required>
                    <option value="" disabled {{ !($pemasokDipilih || $barangSamaDipilih) ? 'selected' : '' }}>
                        Pilih pemasok...</option>
                    @foreach ($pemasoks as $pemasok)
                        <option value="{{ $pemasok->id_pemasok }}"
                            {{ ($pemasokDipilih && session('id_pemasok') == $pemasok->id_pemasok) || ($barangSamaDipilih && session('kondisibarangsama_pembelian')['id_pemasok'] == $pemasok->id_pemasok) ? 'selected' : '' }}>
                            {{ $pemasok->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pemasok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="id_kategori" class="block font-medium text-gray-700 text-md">Kategori Barang:</label>
                <select name="id_kategori" id="id_kategori"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('kategori') border-red-500 @enderror"
                    required>
                    <option value="" disabled selected>Pilih kategori...</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ukuran -->
            <div>
                <label for="id_ukuran" class="block font-medium text-gray-700 text-md">Ukuran:</label>
                <input type="text" id="id_ukuran" name="id_ukuran"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('id_ukuran') border-red-500 @enderror"
                    readonly>
                @error('id_ukuran')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motif -->
            <div>
                <label for="id_motif" class="block font-medium text-gray-700 text-md">Motif:</label>
                <select name="id_motif" id="id_motif"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('motif') border-red-500 @enderror"
                    required>
                    <option value="" disabled selected>Pilih motif...</option>
                    <!-- Opsi motif akan diisi oleh AJAX -->
                </select>
                @error('motif')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <!-- Warna -->
            <div>
                <label for="warna" class="block font-medium text-gray-700 text-md">Warna:</label>
                <select name="warna" id="warna"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('warna') border-red-500 @enderror"
                    onchange="checkWarnaOption(this)" required>
                    <option value="" disabled selected>Pilih warna...</option>
                    <option value="Merah">Merah</option>
                    <option value="Biru">Biru</option>
                    <option value="Hijau">Hijau</option>
                    <option value="Kuning">Kuning</option>
                    <option value="Hitam">Hitam</option>
                    <option value="Putih">Putih</option>
                    <option value="Coklat">Coklat</option>
                    <option value="Ungu">Ungu</option>
                    <option value="Abu">Abu</option>
                    <option value="lainnya">Lainnya...</option> <!-- Opsi untuk input manual -->
                </select>

                <!-- Input teks untuk warna custom -->
                <div id="warnaLainnyaDiv" class="hidden mt-3">
                    <label for="warnaLainnya" class="block text-sm font-medium text-gray-700">Masukkan Warna
                        Lainnya:</label>
                    <input type="text" name="warnaLainnya" id="warnaLainnya"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('warna') border-red-500 @enderror">
                </div>
                @error('warna')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Satuan -->
            <div>
                <label for="id_satuan" class="block font-medium text-gray-700 text-md">Satuan:</label>
                <select name="id_satuan" id="id_satuan"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('satuan') border-red-500 @enderror"
                    required>
                    <option value="" disabled selected>Pilih satuan...</option>
                    @foreach ($satuans as $satuan)
                        <option value="{{ $satuan->id_satuan }}">{{ $satuan->nama_satuan }}</option>
                    @endforeach
                </select>
                @error('satuan')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Beli -->
            <div>
                <label for="h_beli" class="block font-medium text-gray-700 text-md">Harga Beli Per Kodi:</label>
                <input type="number" name="h_beli" id="h_beli" placeholder="Contoh: 90000"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_beli') border-red-500 @enderror"
                    required>
                @error('h_beli')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Jual -->
            {{-- <div>
                <label for="h_jual" class="block font-medium text-gray-700 text-md">Harga Jual:</label>
                <input type="number" name="h_jual" id="h_jual" placeholder="Contoh: 100000"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_jual') border-red-500 @enderror"
                    required>
                @error('h_jual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            <!-- stokqty -->
            <div>
                <label for="stokqty" class="block font-medium text-gray-700 text-md">Kuantitas:</label>
                <input type="number" name="stokqty" id="stokqty" step="0.01" min="0"
                    placeholder="0.00"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('stokqty') border-red-500 @enderror"
                    required>
                @error('stokqty')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gambar" class="block font-medium text-gray-700 text-md">Gambar:</label>
                <input type="file" name="gambar" id="gambar"
                    class="mb-3 mb-4 mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 hover:file:bg-gray-100 @error('gambar') border-red-500 @enderror"
                    accept="image/*" required> <!-- Menambahkan accept untuk hanya file gambar -->

                <div class="relative inline-block">
                    <img id="gambarPreview" src="" alt="Preview Gambar"
                        class="hidden object-cover w-32 h-32 transition-transform duration-200 ease-in-out rounded-lg shadow-lg hover:scale-105 hover:shadow-2xl">
                    <div
                        class="absolute inset-0 transition-opacity duration-300 bg-gray-700 rounded-lg opacity-0 hover:opacity-50">
                    </div>
                </div>

                <script>
                    // Ambil elemen gambar dan input file
                    var inputFile = document.getElementById('gambar');

                    // Event listener untuk input file
                    inputFile.addEventListener('change', function() {
                        var file = inputFile.files[0]; // Ambil file pertama dari input

                        if (file) {
                            var reader = new FileReader();

                            // Event saat file dibaca
                            reader.onload = function(e) {
                                imgPreview.src = e.target.result; // Set src gambar ke hasil pembacaan
                                imgPreview.classList.remove('hidden'); // Tampilkan gambar
                                inputFile.disabled = true; // Nonaktifkan input file
                            };

                            // Membaca file sebagai URL
                            reader.readAsDataURL(file);
                        } else {
                            imgPreview.src = '';
                            imgPreview.classList.add('hidden');
                            inputFile.disabled = false; // Aktifkan input file jika tidak ada file
                        }
                    });

                    var baseUrl = "{{ asset('storage/barang') }}"; // Pastikan ini tetap ada jika diperlukan
                </script>

                @error('gambar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Tambah Barang -->
            <div class="mb-4">
                <button type="submit"
                    class="px-4 py-2 font-bold text-white transition-colors bg-blue-500 rounded hover:bg-blue-600">Tambah
                    ke
                    Keranjang</button>

                <a href="{{ route('pembelian.reset') }}"
                    class="px-4 py-2 font-bold text-white transition-colors bg-red-500 rounded hover:bg-red-600">
                    Reset
                </a>

            </div>

        </div>
    </form>

    <table class="w-full mb-4 overflow-hidden border-collapse rounded-sm table-auto">
        <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
            <tr>
                <th class="px-2 py-3 border border-slate-300">No.</th>
                <th class="px-2 py-3 border border-slate-300">Gambar</th>
                <th class="px-2 py-3 border border-slate-300">Kode Barang</th>
                <th class="px-2 py-3 border border-slate-300">Kategori Barang</th>
                {{-- <th class="px-2 py-3 border border-slate-300">Harga</th> --}}
                <th class="px-2 py-3 border border-slate-300">Qty</th>
                <th class="px-2 py-3 border border-slate-300">Satuan</th>
                <th class="px-2 py-3 border border-slate-300">SubTotal</th>
                {{-- <th class="px-2 py-3 border border-slate-300">Warna</th> --}}
                {{-- <th class="px-2 py-3 border border-slate-300">Motif</th> --}}
                {{-- <th class="px-2 py-3 border border-slate-300">Pemasok</th> --}}
                <th class="px-2 py-3 border border-slate-300">Aksi</th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-300">
            @if (session()->has('cart2'))

                @foreach (session('cart2') as $key => $item)
                    {{-- {{ dd(session()->all()) }} --}}
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $loop->iteration }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            <img src="{{ asset('storage/barang/' . $item['gambar']) }}" alt="Gambar Barang"
                                width="100">
                        </td>

                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap text-pretty">
                            {{ $item['kd_barang'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap text-pretty">
                            {{ $item['kategori_nama'] }}
                        </td>
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">Rp.
                            {{ number_format($item['h_beli'], 0, ',', '.') }}
                        </td> --}}
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['kuantitas'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['satuan_nama'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">

                            Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </td>
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['warna'] }}
                        </td> --}}
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['motif_nama'] }}
                        </td> --}}
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['pemasok_nama'] }}
                        </td> --}}

                        <!-- Tombol Hapus Data di Keranjang-->

                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            <div class="flex justify-center mb-2">
                                <button type="button"
                                    class="flex items-center px-2 py-1 mr-2 text-blue-600 bg-gray-100 border border-gray-300 detail-item-button rounded-xl hover:bg-gray-200"
                                    data-key="{{ $key }}" id="detailBarang">
                                    <i class="mr-2 fas fa-info-circle"></i> Detail
                                </button>
                                <form action="/remove-from-cart2/{{ $key }}" method="POST">
                                    @csrf
                                    <!-- Tombol Hapus -->
                                    <button type="submit"
                                        class="flex items-center px-2 py-1 text-white bg-red-500 border border-red-600 rounded-xl hover:bg-red-600">
                                        <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>

                        </td>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                        Keranjang Kosong
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <script>
        const itemDetailsUrl = "{{ route('item.details') }}";
        const csrfToken = "{{ csrf_token() }}"
    </script>


    <form action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="total2" class="block font-medium text-gray-700">Total</label>
            <input type="text" id="total2" name="subtotal"
                value="{{ 'Rp. ' . number_format(session('subtotal'), 0, ',', '.') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('total2') border-red-500 @enderror"
                readonly>
            @error('total2')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end mt-3">
            <button type="submit"
                class="px-4 py-2 font-bold text-white transition-colors bg-green-500 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Submit
            </button>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatNumber(number) {
                // Fungsi untuk memformat angka dengan titik sebagai pemisah ribuan dan menambahkan "Rp."
                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(number);
            }

            function unformatNumber(formattedNumber) {
                // Fungsi untuk menghapus "Rp." dan titik pemisah ribuan agar bisa dihitung
                return parseFloat(formattedNumber.replace(/[Rp.\s]/g, '').replace(',', '.'));
            }

            function calculateTotal() {
                // Ambil nilai total dari input total2, dan hapus pemisah ribuan dan "Rp."
                const total = unformatNumber(document.getElementById('total2').value) || 0;
            }

            // Hitung total saat halaman dimuat
            calculateTotal();

        });
    </script>


    <script>
        // JavaScript untuk menampilkan input DP jika metode Kredit dipilih
        document.querySelectorAll('input[name="metode_pembayaran"]').forEach(function(element) {
            element.addEventListener('change', function() {
                const paymentKreditDiv = document.getElementById('paymentKreditDiv');
                if (this.value === 'Kredit') {
                    paymentKreditDiv.classList.remove('hidden');
                } else {
                    paymentKreditDiv.classList.add('hidden');
                }
            });
        });

        // Trigger untuk menampilkan DP jika sudah dipilih sebelumnya
        document.querySelector(
            `input[name="metode_pembayaran"][value="{{ old('metode_pembayaran', session('form_data2.metode_pembayaran')) }}"]`
        ).checked = true;
        if (document.querySelector('input[name="metode_pembayaran"]:checked')?.value === 'Kredit') {
            document.getElementById('paymentKreditDiv').classList.remove('hidden');
        }
    </script>


</x-layout>
