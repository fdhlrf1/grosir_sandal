<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Tambah Barang</span>
    </h1>


    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Form Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


            <!-- Kategori -->
            <div>
                <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori Barang:</label>
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

            <!-- Size -->
            <div>
                <label for="size" class="block text-sm font-medium text-gray-700">Ukuran:</label>
                <select name="size" id="size"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('size') border-red-500 @enderror"
                    onchange="checkSizeOption(this)" required>
                    <option value="" disabled selected>Pilih ukuran...</option>
                    <option value="36-40">36-40</option>
                    <option value="36-42">36-42</option>
                    <option value="26-30">26-30</option>
                    <option value="26-32">26-32</option>
                    <option value="lainnya">Lainnya...</option> <!-- Opsi input manual -->
                </select>

                <!-- Input teks untuk ukuran custom -->
                <div id="sizeLainnyaDiv" class="hidden mt-3">
                    <label for="sizeLainnya" class="block text-sm font-medium text-gray-700">Masukkan Ukuran
                        Lainnya:</label>
                    <input type="text" name="sizeLainnya" id="sizeLainnya"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('size') border-red-500 @enderror">
                </div>

                @error('size')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>



            <!-- Warna -->
            <div>
                <label for="warna" class="block text-sm font-medium text-gray-700">Warna:</label>
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



            <!-- Motif -->
            <div>
                <label for="motif" class="block text-sm font-medium text-gray-700">Motif:</label>
                <input type="text" name="motif" id="motif" maxlength="100"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('motif') border-red-500 @enderror"
                    required>
                @error('motif')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <!-- Satuan -->
            <div>
                <label for="id_satuan" class="block text-sm font-medium text-gray-700">Satuan:</label>
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
                <label for="id_pemasok" class="block text-sm font-medium text-gray-700">Pemasok:</label>
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
                <label for="h_beli" class="block text-sm font-medium text-gray-700">Harga Beli:</label>
                <input type="number" name="h_beli" id="h_beli"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_beli') border-red-500 @enderror"
                    required>
                @error('h_beli')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Jual -->
            <div>
                <label for="h_jual" class="block text-sm font-medium text-gray-700">Harga Jual:</label>
                <input type="number" name="h_jual" id="h_jual"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_jual') border-red-500 @enderror"
                    required>
                @error('h_jual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok:</label>
                <input type="number" name="stok" id="stok"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('stok') border-red-500 @enderror"
                    required>
                @error('stok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar:</label>
                <input type="file" name="gambar" id="gambar"
                    class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 hover:file:bg-gray-100 @error('gambar') border-red-500 @enderror">
                @error('gambar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan
            </button>
            <button type="reset"
                class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Reset
            </button>
            <a href="{{ route('barang.index') }}"
                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </form>

    <pre>
{{-- {{ dd($pemasok->id_pemasok) }} --}}
{{-- {{ print_r($satuans) }} --}}
{{-- {{ print_r($kategoris) }} --}}
</pre>

</x-layout>
