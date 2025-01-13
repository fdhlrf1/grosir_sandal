<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>


    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Pencatatan Pembelian Barang</span>
    </h1>


    <!-- UI Formulir untuk Pembelian -->
    <!-- Nomor Pembelian -->
    <form action="/add-to-cart2" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
            <!-- Input Nomor Pembelian -->
            <div>
                <label for="nopembelian" class="block font-medium text-gray-700 text-md">Nomor Pembelian:</label>
                <input type="text" name="nopembelian" id="nopembelian" maxlength="100"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('nopembelian') border-red-500 @enderror"
                    value="{{ session('nopembelian', $nopembelian) }}" readonly>
                @error('nopembelian')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kd_barang" class="block font-medium text-gray-700 text-md">Kode Barang:</label>
                <input type="text" name="kd_barang" id="kd_barang" maxlength="100"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('kd_barang') border-red-500 @enderror"
                    value="{{ session('kd_barang') }}" readonly>
                @error('kd_barang')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Tanggal Pembelian -->
            {{-- <div>
                <label for="tanggalpembelian" class="block font-medium text-gray-700 text-md">Tanggal Pembelian:</label>
                <input type="date" name="tanggalpembelian" id="tanggalpembelian"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('tanggalpembelian') border-red-500 @enderror"
                    value="{{ old('tanggalpembelian') }}">
                @error('tanggalpembelian')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}
        </div>


        <!-- Metode Pembayaran -->
        <div class="mb-4">
            <label class="block font-medium text-gray-700 text-md">Metode Pembayaran</label>
            <div class="flex items-center mt-2">
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
                <input type="number" name="paymentKredit" id="paymentKredit"
                    value="{{ old('paymentKredit', session('form_data2.paymentKredit')) }}"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('paymentKredit') border-red-500 @enderror">
            </div>

            @error('metode_pembayaran')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                    onchange="checkWarnaOption(this)">
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

            <!-- Pemasok -->
            <div>
                <label for="id_pemasok" class="block font-medium text-gray-700 text-md">Pemasok:</label>
                <select name="id_pemasok" id="id_pemasok"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('pemasok') border-red-500 @enderror"
                    required>
                    <option value="" disabled selected>Pilih pemasok...</option>
                    @foreach ($pemasoks as $pemasok)
                        <option value="{{ $pemasok->id_pemasok }}">{{ $pemasok->nama }}</option>
                    @endforeach
                </select>
                @error('pemasok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Beli -->
            <div>
                <label for="h_beli" class="block font-medium text-gray-700 text-md">Harga Beli:</label>
                <input type="number" name="h_beli" id="h_beli"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_beli') border-red-500 @enderror"
                    required>
                @error('h_beli')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Jual -->
            <div>
                <label for="h_jual" class="block font-medium text-gray-700 text-md">Harga Jual:</label>
                <input type="number" name="h_jual" id="h_jual"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_jual') border-red-500 @enderror"
                    required>
                @error('h_jual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- stokqty -->
            <div>
                <label for="stokqty" class="block font-medium text-gray-700 text-md">Kuantitas:</label>
                <input type="number" name="stokqty" id="stokqty"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('stokqty') border-red-500 @enderror"
                    required>
                @error('stokqty')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label for="gambar" class="block font-medium text-gray-700 text-md">Gambar:</label>
                <input type="file" name="gambar" id="gambar"
                    class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 hover:file:bg-gray-100 @error('gambar') border-red-500 @enderror">
                @error('gambar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Tambah Barang -->
            <div class="mb-4">
                <button type="submit"
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">Tambah
                    ke
                    Keranjang</button>

                <a href="{{ route('pembelian.reset') }}"
                    class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-600">
                    Reset
                </a>

            </div>

        </div>
    </form>

    <table class="w-full mb-4 overflow-hidden border-collapse rounded-sm table-auto">
        <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
            <tr>
                <th class="px-3 py-3 border border-slate-300">No.</th>
                <th class="px-3 py-3 border border-slate-300">Gambar</th>
                <th class="px-3 py-3 border border-slate-300">Kode Barang</th>
                <th class="px-3 py-3 border border-slate-300">Kategori Barang</th>
                <th class="px-3 py-3 border border-slate-300">Harga</th>
                <th class="px-3 py-3 border border-slate-300">Kuantitas</th>
                <th class="px-3 py-3 border border-slate-300">Satuan</th>
                <th class="px-3 py-3 border border-slate-300">SubTotal</th>
                <th class="px-3 py-3 border border-slate-300">Warna</th>
                <th class="px-3 py-3 border border-slate-300">Motif</th>
                <th class="px-3 py-3 border border-slate-300">Size</th>

                <th class="px-3 py-3 border border-slate-300">Aksi</th>
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

                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['kd_barang'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['id_kategori'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['h_beli'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['stok'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $item['id_satuan'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['subtotal'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['warna'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['motif'] }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap subtotal">
                            {{ $item['size'] }}
                        </td>

                        <!-- Tombol Hapus Data di Keranjang-->
                        <form action="/remove-from-cart2/{{ $key }}" method="POST">
                            @csrf
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                <button type="submit"
                                    class="flex items-center px-4 py-2 text-white bg-red-500 rounded-lg shadow-md hover:bg-red-600">
                                    <i class="mr-2 fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </form>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                        Keranjang Kosong
                    </td>
                </tr>
            @endif
        </tbody>
    </table>


    <form action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Total, Payment, and Change -->
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">

            <div class="mb-4">
                <label for="total2" class="block font-medium text-gray-700">Total</label>
                <input type="text" id="total2" name="subtotal" value="{{ session('subtotal') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('total2') border-red-500 @enderror"
                    readonly>
                @error('total2')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="bayar2" class="block font-medium text-gray-700">Bayar</label>
                <input type="number" id="bayar2" name="bayar2"
                    value="{{ session('form_data2.bayar2', old('bayar2')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('bayar2') border-red-500 @enderror
                     @if (session('form_data2.bayar2')) bg-gray-200 text-gray-700 cursor-default focus:ring-0 focus:border-gray-300 @endif"
                    @if (session('form_data2.bayar2')) readonly @endif>
                @error('bayar2')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kembalian2" class="block font-medium text-gray-700">Kembalian</label>
                <input type="text" id="kembalian2" name="kembalian2"
                    value="{{ session('kembalian2', old('kembalian2')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm @error('kembalian2') border-red-500 @enderror"
                    readonly>
                @error('kembalian2')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <script></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function calculateTotal() {
                    // Ambil nilai total dari input total2
                    const total = parseFloat(document.getElementById('total2').value) || 0;

                    // Ambil nilai bayar dari input bayar2
                    const bayar = parseFloat(document.getElementById('bayar2').value) || 0;

                    // Hitung kembalian
                    const kembalian = bayar - total;

                    // Update nilai kembalian di input kembalian2
                    document.getElementById('kembalian2').value = kembalian >= 0 ? kembalian : 0;
                }

                // Hitung total saat halaman dimuat
                calculateTotal();

                // Tambahkan event listener pada input bayar2 agar menghitung ulang saat ada perubahan
                document.getElementById('bayar2').addEventListener('input', calculateTotal);
            });
        </script>


        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Submit
                to
                Database</button>
        </div>


        <!-- Modal -->
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
                `input[name="metode_pembayaran"][value="{{ old('metode_pembayaran', session('form_data2.metode_pembayaran')) }}"]`
            ).checked = true;
            if (document.querySelector('input[name="metode_pembayaran"]:checked')?.value === 'Kredit') {
                document.getElementById('paymentKreditDiv').classList.remove('hidden');
            }
        </script>


</x-layout>
