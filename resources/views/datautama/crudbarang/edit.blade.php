<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Edit Barang</span>
    </h1>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Form Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- Kode Barang -->
            {{-- <div>
                <label for="kd_barang" class="block text-sm font-medium text-gray-700">Kode Barang:</label>
                <input type="text" name="kd_barang" id="kd_barang" value="{{ old('kd_barang', $barang->kd_barang) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('kd_barang') border-red-500 @enderror"
                    required @readonly(true)>
                @error('kd_barang')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}



            <!-- Kategori -->
            <div>
                <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori:</label>
                <select name="id_kategori" id="id_kategori"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('kategori') border-red-500 @enderror"
                    required>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id_kategori }}"
                            {{ old('id_kategori', $barang->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Size -->
            <div>
                <label for="id_ukuran" class="block text-sm font-medium text-gray-700">Ukuran:</label>
                <input type="text" name="id_ukuran" id="id_ukuran" value="{{ old('id_ukuran', $barang->id_ukuran) }}"
                    readonly
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('size') border-red-500 @enderror">
                @error('size')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- <!-- Size -->
            <div>
                <label for="id_ukuran" class="block text-sm font-medium text-gray-700">Ukuran:</label>
                <input type="text" name="id_ukuran" id="id_ukuran" value="{{ old('size', $barang->size) }}" readonly
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-200 text-gray-700 cursor-default focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('size') border-red-500 @enderror">
                @error('size')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}


            <!-- Motif -->
            <div>
                <label for="id_motif" class="block text-sm font-medium text-gray-700">Motif:</label>
                <select name="id_motif" id="id_motif"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('motif') border-red-500 @enderror"
                    required>
                    <!-- Opsi motif akan diisi oleh AJAX -->
                </select>
                @error('motif')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <!-- Warna -->
            <div>
                <label for="warna" class="block text-sm font-medium text-gray-700">Warna:</label>
                <select name="warna" id="warna"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('warna') border-red-500 @enderror"
                    onchange="checkWarnaOption(this)">
                    <option value="" disabled
                        {{ old('warna', $barang->warna) == '' || !in_array($barang->warna, ['Merah', 'Biru', 'Hijau', 'Kuning', 'Hitam', 'Putih', 'Coklat', 'Ungu', 'Abu']) ? 'selected' : '' }}>
                        Pilih
                        warna...</option>
                    <option value="Merah" {{ old('warna', $barang->warna) == 'Merah' ? 'selected' : '' }}>Merah
                    </option>
                    <option value="Biru" {{ old('warna', $barang->warna) == 'Biru' ? 'selected' : '' }}>Biru</option>
                    <option value="Hijau" {{ old('warna', $barang->warna) == 'Hijau' ? 'selected' : '' }}>Hijau
                    </option>
                    <option value="Kuning" {{ old('warna', $barang->warna) == 'Kuning' ? 'selected' : '' }}>Kuning
                    </option>
                    <option value="Hitam" {{ old('warna', $barang->warna) == 'Hitam' ? 'selected' : '' }}>Hitam
                    </option>
                    <option value="Putih" {{ old('warna', $barang->warna) == 'Putih' ? 'selected' : '' }}>Putih
                    </option>
                    <option value="Coklat" {{ old('warna', $barang->warna) == 'Coklat' ? 'selected' : '' }}>Coklat
                    </option>
                    <option value="Ungu" {{ old('warna', $barang->warna) == 'Ungu' ? 'selected' : '' }}>Ungu</option>
                    <option value="Abu" {{ old('warna', $barang->warna) == 'Abu' ? 'selected' : '' }}>Abu</option>
                    <option value="lainnya" {{ old('warna', $barang->warna) == 'lainnya' ? 'selected' : '' }}>
                        Lainnya...</option>
                </select>

                <!-- Input teks untuk warna custom -->
                <div id="warnaLainnyaDiv"
                    class="{{ old('warna', $barang->warna) == 'lainnya' || !in_array($barang->warna, ['Merah', 'Biru', 'Hijau', 'Kuning', 'Hitam', 'Putih', 'Coklat', 'Ungu', 'Abu', 'lainnya']) ? '' : 'hidden' }} mt-3">
                    <label for="warnaLainnya" class="block text-sm font-medium text-gray-700">Masukkan Warna
                        Lainnya:</label>
                    <input type="text" name="warnaLainnya" id="warnaLainnya"
                        value="{{ old('warnaLainnya', $barang->warna != 'lainnya' ? $barang->warna : '') }}"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                @error('warna')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Satuan -->
            <div>
                <label for="id_satuan" class="block text-sm font-medium text-gray-700">Satuan:</label>
                <select name="id_satuan" id="id_satuan"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('satuan') border-red-500 @enderror"
                    required>
                    @foreach ($satuans as $satuan)
                        <option value="{{ $satuan->id_satuan }}"
                            {{ old('id_satuan', $barang->id_satuan) == $satuan->id_satuan ? 'selected' : '' }}>
                            {{ $satuan->nama_satuan }}
                        </option>
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
                    @foreach ($pemasoks as $pemasok)
                        <option value="{{ $pemasok->id_pemasok }}"
                            {{ old('id_pemasok', $barang->id_pemasok) == $pemasok->id_pemasok ? 'selected' : '' }}>
                            {{ $pemasok->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pemasok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Beli -->
            <div>
                <label for="h_beli" class="block text-sm font-medium text-gray-700">Harga Beli:</label>
                <input type="number" name="h_beli" id="h_beli" value="{{ old('h_beli', $barang->h_beli) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_beli') border-red-500 @enderror"
                    required>
                @error('h_beli')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga Jual -->
            <div>
                <label for="h_jual" class="block text-sm font-medium text-gray-700">Harga Jual:</label>
                <input type="number" name="h_jual" id="h_jual" value="{{ old('h_jual', $barang->h_jual) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('h_jual') border-red-500 @enderror"
                    required>
                @error('h_jual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok:</label>
                <input type="text" name="stok" id="stok"
                    value="{{ old('stok', $barang->satuan->nama_satuan == 'Kodi' ? $barang->stok / $barang->satuan->konversi : $barang->stok) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('stok') border-red-500 @enderror"
                    required>
                {{-- kalau id_satuan nya 2 maka dikonversi ke kodi --}}
                @error('stok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar:</label>
                <input type="file" name="gambar" id="gambar"
                    class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 hover:file:bg-gray-100 @error('gambar') border-red-500 @enderror">
                @if ($barang->gambar)
                    <div class="mt-2">
                        <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="Current Image"
                            width="100">
                    </div>

                    <!-- Tombol Hapus Gambar -->
                    <form action="{{ route('barang.hapus', $barang->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-200">
                            Hapus Gambar
                        </button>
                    </form>
                @endif
                @error('gambar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var kategoriSelect = document.getElementById('id_kategori');
                var ukuranInput = document.getElementById('id_ukuran');
                var motifSelect = document.getElementById('id_motif');
                var selectedMotifId =
                    "{{ $barang->id_motif }}"; // Ambil motif yang dipilih sebelumnya

                // Fungsi untuk memuat ukuran dan motif berdasarkan kategori yang dipilih
                function loadUkuranAndMotif(idKategori) {
                    // Reset input ukuran sebelum fetch
                    ukuranInput.value = 'Loading...';

                    // Fetch data ukuran berdasarkan kategori yang dipilih
                    fetch(`/get-ukuran/${idKategori}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Data Ukuran:', data);
                            if (data.length > 0) {
                                // Gabungkan semua ukuran yang diterima ke dalam satu string
                                ukuranInput.value = data.join(', ');
                            } else {
                                ukuranInput.value = 'Ukuran tidak tersedia';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            ukuranInput.value = 'Error loading data...';
                        });

                    // Fetch Motif berdasarkan kategori
                    motifSelect.innerHTML =
                        '<option value="" disabled selected>Loading...</option>'; // menyetel pemberitahuan loading
                    fetch(`/get-motif/${idKategori}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Data Motif:', data);
                            // Hapus opsi sebelumnya
                            motifSelect.innerHTML = '<option value="" disabled>Pilih motif...</option>';

                            // Tambahkan opsi motif baru dari hasil query
                            for (const id_motif in data) {
                                const option = document.createElement('option');
                                option.value = id_motif;
                                option.textContent = data[id_motif];

                                // Jika ini adalah motif yang sudah dipilih sebelumnya, set as selected
                                if (id_motif === selectedMotifId) {
                                    option.selected = true;
                                }

                                motifSelect.appendChild(option);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching motif:', error);
                            motifSelect.innerHTML = '<option value="" disabled>Error loading motif...</option>';
                        });
                }

                // Event listener untuk kategori select
                kategoriSelect.addEventListener('change', function() {
                    var idKategori = kategoriSelect.value;
                    loadUkuranAndMotif(idKategori);
                });

                // Muat ukuran dan motif saat halaman dimuat
                var initialKategoriId = kategoriSelect.value;
                if (initialKategoriId) {
                    loadUkuranAndMotif(initialKategoriId);
                }
            });
        </script>

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Kode yang sudah ada...

                // Menangani event submit form
                var form = document.getElementById('update-form');
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah submit default

                    // Ambil nilai dari input
                    var idMotif = motifSelect.value; // Ambil nilai dari select motif
                    var idKategori = kategoriSelect.value; // Ambil nilai dari select kategori
                    var idUkuran = ukuranInput.value; // Ambil ukuran
                    // Ambil nilai input lainnya sesuai kebutuhan

                    console.log('Updating with id_motif:', idMotif); // Log untuk debugging

                    // Kirim data ke server menggunakan fetch
                    fetch('/update-barang', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Sertakan CSRF token jika menggunakan Laravel
                            },
                            body: JSON.stringify({
                                id_pemasok: validated.id_pemasok,
                                id_satuan: validated.id_satuan,
                                id_kategori: idKategori,
                                id_motif: idMotif,
                                h_beli: validated.h_beli,
                                h_jual: validated.h_jual,
                                stok: stok,
                                warna: validated.warna,
                                size: idUkuran,
                                gambar: image.hashName(), // Pastikan ini sesuai dengan kebutuhan
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Update successful!');
                            } else {
                                console.error('Update failed:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error during update:', error);
                        });
                });
            });
        </script> --}}



        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Perubahan
            </button>
            <a href="{{ route('barang.index') }}"
                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </a>
        </div>
    </form>
</x-layout>
