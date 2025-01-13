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
        <span class="text-blue-600">Penjualan</span>
    </h1>

    @include('transaksi.modal-detail-penjualan')
    @include('transaksi.modal-pilih-penjualan')

    <!-- UI Formulir untuk Transaksi -->
    <!-- Nomor Transaksi -->
    <form action="{{ route('tambah_keranjang') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="no_transaksi" class="block font-medium text-gray-700 text-md">Nomor Transaksi:</label>
            <input type="text" name="no_transaksi" id="no_transaksi" maxlength="100"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('no_transaksi') border-red-500 @enderror"
                value="{{ session('nopenjualan', $nopenjualan) }}" readonly>
            @error('no_transaksi')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Metode Pembayaran -->
        {{-- <div class="mb-4">
            <label class="block font-medium text-gray-700 text-md">Metode Pembayaran</label>
            <div class="flex items-center mt-2">

                <input type="hidden" name="metode_pembayaran"
                    value="{{ old('metode_pembayaran', session('form_data.metode_pembayaran')) }}">

                <input type="radio" id="tunai" name="metode_pembayaran" value="Tunai"
                    class="form-radio @error('metode_pembayaran') border-red-500 @enderror"
                    {{ old('metode_pembayaran', session('form_data.metode_pembayaran')) === 'Tunai' ? 'checked' : '' }}
                    @if (old('metode_pembayaran', session('form_data.metode_pembayaran'))) disabled @endif>
                <label for="tunai" class="ml-2 text-gray-600">Tunai</label>
            </div>
            <div class="flex items-center mt-2">
                <input type="radio" id="kredit" name="metode_pembayaran" value="Kredit"
                    class="form-radio @error('metode_pembayaran') border-red-500 @enderror"
                    {{ old('metode_pembayaran', session('form_data.metode_pembayaran')) === 'Kredit' ? 'checked' : '' }}
                    @if (old('metode_pembayaran', session('form_data.metode_pembayaran'))) disabled @endif>
                <label for="kredit" class="ml-2 text-gray-600">Kredit</label>
            </div>

            <div id="paymentKreditDiv" class="hidden mt-3">
                <label for="paymentKredit" class="block text-sm font-medium text-gray-700">Masukkan Nominal
                    DP:</label>
                <input type="text" name="paymentKredit" id="paymentKredit"
                    value="{{ is_numeric(old('paymentKredit', session('form_data.paymentKredit'))) ? number_format((float) old('paymentKredit', session('form_data.paymentKredit')), 0, ',', '.') : old('paymentKredit', session('form_data.paymentKredit')) }}"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('paymentKredit') border-red-500 @enderror
                    @if (old('metode_pembayaran', session('form_data.metode_pembayaran'))) bg-gray-200 text-gray-700 cursor-default focus:ring-0 focus:border-gray-300 @endif"
                    @if (old('metode_pembayaran', session('form_data.metode_pembayaran'))) readonly @endif>
            </div>

            @error('metode_pembayaran')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div> --}}



        {{-- <a href="{{ route('test_toast') }}">
            <p class="px-2 py-2 bg-slate-800">TEST TOAST</p>
        </a> --}}

        <!-- Informasi Konsumen -->
        <div class="flex justify-between mb-2">
            <!-- Nama Konsumen -->
            <div class="w-1/2 mb-4 mr-4">
                <label for="nama_konsumen" class="block font-medium text-gray-700 text-md">Nama Konsumen:</label>
                <!-- Input hidden untuk mengirim nilai nama_konsumen jika select di disabled -->
                @if (session('form_data.nama_konsumen'))
                    <input type="hidden" name="nama_konsumen"
                        value="{{ session('form_data.nama_konsumen', old('nama_konsumen')) }}">
                @endif
                <select name="nama_konsumen" id="nama_konsumen"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nama_konsumen') border-red-500 @enderror
                    {{ session('form_data.nama_konsumen') ? 'bg-gray-200 text-gray-700 cursor-default readonly-select' : '' }}"
                    required>
                    <option value="" disabled
                        {{ session('form_data.nama_konsumen', old('nama_konsumen')) ? '' : 'selected' }}>Pilih nama
                        konsumen...
                    </option>
                    @foreach ($konsumens as $konsumen)
                        <option value="{{ $konsumen->nama }}"
                            {{ session('form_data.nama_konsumen', old('nama_konsumen')) === $konsumen->nama ? 'selected' : '' }}>
                            {{ $konsumen->nama }}
                        </option>
                    @endforeach
                </select>
                @error('nama_konsumen')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="w-1/2 mb-4 mr-4">
                <label for="alamat" class="block font-medium text-gray-700 text-md">Alamat</label>
                <input type="text" id="alamat" name="alamat"
                    value="{{ session('form_data.alamat', old('alamat')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('alamat') border-red-500 @enderror"
                    readonly>
                @error('alamat')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Telepon -->
            <div class="w-1/2 mb-4">
                <label for="telepon" class="block font-medium text-gray-700">Telepon</label>
                <input type="text" id="telepon" name="telepon"
                    value="{{ session('form_data.telepon', old('telepon')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('telepon') border-red-500 @enderror"
                    readonly>
                @error('telepon')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- <h1 class="pb-2 mb-4 text-xl font-semibold text-gray-800 border-b-2 border-gray-300">
            <span class="text-blue-600">Penjualan Barang Anda</span>
            <span class="block mt-2 text-base font-light text-gray-600">Pilih barang yang akan
                baru.</span>
        </h1> --}}

        <!-- Tombol Pilih Barang -->
        <div class="mb-5">
            <button type="button" id="cariBarangButton"
                class="px-4 py-2 font-bold text-white transition-colors bg-blue-500 rounded hover:bg-blue-600">Pilih
                Barang</button>
        </div>

        <!-- Formulir Barang -->

        <!-- Kode Barang -->
        <div class="flex justify-between">
            <div class="w-1/2 mb-4 mr-4">
                <label for="kd_barang" class="block font-medium text-gray-700 text-md">Kode Barang:</label>
                <input type="text" id="kd_barang" name="kd_barang"
                    value="{{ old('kd_barang', session('form_data.kd_barang')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('kd_barang') border-red-500 @enderror"
                    readonly>
                @error('kd_barang')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Kategori -->
            <div class="w-1/2 mb-4 mr-4">
                <label for="kategori" class="block font-medium text-gray-700">Kategori</label>
                <input type="text" id="kategori" name="kategori"
                    value="{{ old('kategori', session('form_data.kategori')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('kategori') border-red-500 @enderror"
                    readonly>
                @error('kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Motif -->
            <div class="w-1/2 mb-4 mr-4">
                <label for="motif" class="block font-medium text-gray-700 text-md">Motif</label>
                <input type="text" id="motif" name="motif"
                    value="{{ old('motif', session('form_data.motif')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('motif') border-red-500 @enderror"
                    readonly>
                @error('motif')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Ukuran -->
            <div>
                <input type="hidden" id="id_ukuran" name="id_ukuran" readonly>
                <!-- Warna -->
                <input type="hidden" name="warna" id="warna">
            </div>


            <!-- Stok -->
            <div class="w-1/2 mb-4">
                <label for="stok" class="block font-medium text-gray-700">Stok</label>
                <input type="text" id="stok" name="stok"
                    value="{{ old('stok', session('form_data.stok')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('stok') border-red-500 @enderror"
                    readonly>
                @error('stok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- <!-- Size -->
            <div class="w-1/2 mb-4">
                <label for="size" class="block font-medium text-gray-700">Size</label>
                <input type="text" id="size" name="size"
                    value="{{ old('size', session('form_data.size')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('size') border-red-500 @enderror"
                    readonly>
                @error('size')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}
        </div>

        <div class="flex justify-between">
            <!-- Satuan -->
            <div class="w-1/2 mb-4 mr-4">
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

            <!-- Kuantitas -->
            <div class="w-1/2 mb-4">
                <label for="qty" class="block font-medium text-gray-700">Kuantitas</label>
                <input type="number" id="qty" name="qty" step="0.01" min="0"
                    placeholder="0.00"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('qty') border-red-500 @enderror"
                    required>
                @error('qty')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Harga -->
        <input type="hidden" id="h_jual" name="h_jual"
            value="{{ session('form_data.h_jual', old('h_jual')) }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('h_jual') border-red-500 @enderror"
            readonly>
        {{-- @error('h_jual')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror --}}

        <input type="hidden" name="h_beli" id="h_beli" placeholder="Contoh: 90000"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_beli') border-red-500 @enderror"
            required>

        <!-- Satuan -->
        {{-- <input type="hidden" id="satuan" name="satuan"
            value="{{ old('satuan', session('form_data.satuan')) }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('satuan') border-red-500 @enderror"
            readonly>
        @error('satuan')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror --}}



        <!-- Tombol Tambah Barang -->
        <div class="mb-4">
            <button type="submit"
                class="px-4 py-2 font-bold text-white transition-colors bg-blue-500 rounded hover:bg-blue-600">Tambah
                ke
                Keranjang</button>

            <a href="{{ route('transaksi.reset') }}"
                class="px-4 py-2 font-bold text-white transition-colors bg-red-500 rounded hover:bg-red-600">
                Reset
            </a>

        </div>
    </form>



    <table class="w-full mb-4 overflow-hidden border-collapse rounded-sm table-auto">
        <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
            <tr>
                <th class="px-3 py-3 border border-slate-300">No.</th>
                <th class="px-3 py-3 border border-slate-300">Kode Barang</th>
                <th class="px-3 py-3 border border-slate-300">Kategori Barang</th>
                <th class="px-3 py-3 border border-slate-300">Harga</th>
                <th class="px-3 py-3 border border-slate-300">Qty</th>
                <th class="px-3 py-3 border border-slate-300">Satuan</th>
                <th class="px-3 py-3 border border-slate-300">SubTotal</th>
                <th class="px-3 py-3 border border-slate-300">Aksi</th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-300">
            @if (session()->has('cart'))
                @foreach (session('cart') as $key => $item)
                    {{-- {{ dd(session()->all()) }} --}}
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $loop->iteration }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['kd_barang'] }}
                        </td>

                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['kategori'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">Rp.
                            {{ number_format($item['harga'], 0, ',', '.') }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['kuantitasblade'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['satuan'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </td>
                        <!-- Tombol Hapus Data di Keranjang-->
                        <form action="/remove-from-cart/{{ $key }}" method="POST">
                            @csrf
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                <button type="submit"
                                    class="flex items-center px-4 py-2 text-white transition-colors bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                    <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </form>

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

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <!-- Total, Payment, and Change -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="mb-4">
                <label for="total" class="block font-medium text-gray-700">Total</label>
                <input type="text" id="total" name="total"
                    value="{{ is_numeric(session('form_data.total', old('total'))) ? number_format((float) session('form_data.total', old('total')), 0, ',', '.') : session('form_data.total', old('total')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('total') border-red-500 @enderror"
                    readonly>
                @error('total')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="bayar" class="block font-medium text-gray-700">Bayar</label>
                <input type="text" id="bayar" name="bayar"
                    value="{{ is_numeric(session('form_data.bayar', old('bayar'))) ? number_format((float) session('form_data.bayar', old('bayar')), 0, ',', '.') : session('form_data.bayar', old('bayar')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('bayar') border-red-500 @enderror
                    @if (session('form_data.bayar')) bg-gray-200 text-gray-700 cursor-default focus:ring-0 focus:border-gray-300 @endif"
                    @if (session('form_data.bayar')) readonly @endif min="1">
                @error('bayar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="mb-4">
                <label for="kembalian" class="block font-medium text-gray-700">Kembalian</label>
                <input type="text" id="kembalian" name="kembalian"
                    value="{{ session('kembalian', old('kembalian')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('kembalian') border-red-500 @enderror"
                    readonly>
                @error('kembalian')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="sisa" class="block font-medium text-gray-700">Sisa</label>
                <input type="text" id="sisa" name="sisa" value="{{ session('sisa', old('sisa')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('sisa') border-red-500 @enderror"
                    readonly>
                @error('sisa')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- <div id="tanggaljatuhtempoDiv" class="hidden mt-2">
            <label for="tanggal_jatuh_tempo" class="block font-medium text-gray-900 dark:text-white">Tanggal
                Pelunasan</label>
            <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                class="tanggal_jatuh_tempo mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('tanggal_jatuh_tempo') border-red-500 @enderror"
                placeholder="tanggal pelunasan" required="">
            @error('tanggal_jatuh_tempo')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div> --}}



        <!-- Submit Button -->
        <div class="flex justify-end mt-4">
            <button type="submit"
                class="px-4 py-2 font-bold text-white transition-colors bg-green-500 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Submit</button>
        </div>
        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set the minimum date for the tanggal_jatuh_tempo input
            // const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
            // document.getElementById('tanggal_jatuh_tempo').setAttribute('min', today);

            function formatNumber(number) {
                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(number);
            }

            function unformatNumber(formattedNumber) {
                return parseFloat(formattedNumber.replace(/[Rp.\s]/g, '').replace(',', '.'));
            }

            function calculateTotal() {
                let total = 0;

                // Ambil semua elemen subtotal
                document.querySelectorAll('.subtotal').forEach(function(element) {
                    total += unformatNumber(element.textContent) || 0;
                });

                // Update input total
                document.getElementById('total').value = formatNumber(total);

                // Ambil nilai bayar dan hitung kembalian/sisa
                const bayarField = document.getElementById('bayar');
                const bayar = unformatNumber(document.getElementById('bayar').value) || 0;
                const kembalian = bayar - total;
                const sisa = total - bayar;

                // Update input kembalian
                document.getElementById('kembalian').value = formatNumber(kembalian >= 0 ? kembalian : 0);

                // Update input sisa (jika bayar kurang dari total)
                document.getElementById('sisa').value = formatNumber(sisa > 0 ? sisa : 0);

                // Menampilkan atau menyembunyikan tanggal jatuhtempoDiv
                // const tanggalJatuhTempoDiv = document.getElementById('tanggaljatuhtempoDiv');
                // if (bayarField.value === '' || sisa <= 0) {
                //     tanggalJatuhTempoDiv.classList.add('hidden'); // Sembunyikan div
                // } else {
                //     tanggalJatuhTempoDiv.classList.remove('hidden'); // Tampilkan div
                // }
            }

            // Fungsi untuk memformat input bayar
            function formatBayar() {
                let bayarField = document.getElementById('bayar');
                let bayarValue = unformatNumber(bayarField.value);

                // Validasi untuk mencegah input negatif
                if (bayarValue < 0) {
                    alert("Input tidak boleh negatif!");
                    bayarField.value = ''; // Kosongkan input jika negatif
                } else if (!isNaN(bayarValue)) {
                    bayarField.value = formatNumber(bayarValue);
                }

                calculateTotal(); // Hitung ulang total
            }

            // Hitung total ketika halaman dimuat
            calculateTotal();

            // Tambahkan event listener pada input bayar
            document.getElementById('bayar').addEventListener('input', formatBayar);
            document.getElementById('bayar').addEventListener('input', calculateTotal);
        });
    </script>



    {{-- script penting --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var namaKonsumenSelect = document.getElementById('nama_konsumen');
            var alamatInput = document.getElementById('alamat');
            var teleponInput = document.getElementById('telepon');

            // Mendapatkan data konsumen dari Laravel dengan aman
            var konsumenData = @json($konsumens->items());

            // Fungsi untuk mengisi alamat dan telepon sesuai dengan konsumen yang dipilih
            namaKonsumenSelect.addEventListener('change', function() {
                var selectedKonsumen = konsumenData.find(function(konsumen) {
                    return konsumen.nama === namaKonsumenSelect.value;
                });

                if (selectedKonsumen) {
                    alamatInput.value = selectedKonsumen.alamat;
                    teleponInput.value = selectedKonsumen.telepon;
                } else {
                    alamatInput.value = '';
                    teleponInput.value = '';
                }
            });
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
            `input[name="metode_pembayaran"][value="{{ old('metode_pembayaran', session('form_data.metode_pembayaran')) }}"]`
        ).checked = true;
        if (document.querySelector('input[name="metode_pembayaran"]:checked')?.value === 'Kredit') {
            document.getElementById('paymentKreditDiv').classList.remove('hidden');
        }
    </script>

</x-layout>
