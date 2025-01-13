@foreach ($barangs as $barang)
    <!-- Main modal -->
    <div id="edit-barang-modal{{ $barang->id }}" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Barang
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-barang-modal{{ $barang->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data"
                    class="p-4 md:p-5">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="id_kategori"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori:</label>
                            <select name="id_kategori" id="id_kategori"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('kategori') border-red-500 @enderror"
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

                        <div class="col-span-2 sm:col-span-1">
                            <label for="id_ukuran"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ukuran:</label>
                            <input type="text" name="id_ukuran" id="id_ukuran"
                                value="{{ old('id_ukuran', $barang->id_ukuran) }}" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('size') border-red-500 @enderror">
                            @error('size')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="id_motif"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motif:</label>
                            <select name="id_motif" id="id_motif"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('motif') border-red-500 @enderror"
                                required>
                                <!-- Opsi motif akan diisi oleh AJAX -->
                            </select>
                            @error('motif')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="warna"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Warna:</label>
                            <select name="warna" id="warna"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('warna') border-red-500 @enderror"
                                onchange="checkWarnaOption(this)">
                                <option value="" disabled
                                    {{ old('warna', $barang->warna) == '' || !in_array($barang->warna, ['Merah', 'Biru', 'Hijau', 'Kuning', 'Hitam', 'Putih', 'Coklat', 'Ungu', 'Abu']) ? 'selected' : '' }}>
                                    Pilih
                                    warna...</option>
                                <option value="Merah" {{ old('warna', $barang->warna) == 'Merah' ? 'selected' : '' }}>
                                    Merah
                                </option>
                                <option value="Biru" {{ old('warna', $barang->warna) == 'Biru' ? 'selected' : '' }}>
                                    Biru</option>
                                <option value="Hijau" {{ old('warna', $barang->warna) == 'Hijau' ? 'selected' : '' }}>
                                    Hijau
                                </option>
                                <option value="Kuning"
                                    {{ old('warna', $barang->warna) == 'Kuning' ? 'selected' : '' }}>Kuning
                                </option>
                                <option value="Hitam" {{ old('warna', $barang->warna) == 'Hitam' ? 'selected' : '' }}>
                                    Hitam
                                </option>
                                <option value="Putih" {{ old('warna', $barang->warna) == 'Putih' ? 'selected' : '' }}>
                                    Putih
                                </option>
                                <option value="Coklat"
                                    {{ old('warna', $barang->warna) == 'Coklat' ? 'selected' : '' }}>Coklat
                                </option>
                                <option value="Ungu" {{ old('warna', $barang->warna) == 'Ungu' ? 'selected' : '' }}>
                                    Ungu</option>
                                <option value="Abu" {{ old('warna', $barang->warna) == 'Abu' ? 'selected' : '' }}>
                                    Abu</option>
                                <option value="lainnya"
                                    {{ old('warna', $barang->warna) == 'lainnya' ? 'selected' : '' }}>
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


                        <div class="col-span-2 sm:col-span-1">
                            <label for="id_satuan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Satuan:</label>
                            <select name="id_satuan" id="id_satuan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('satuan') border-red-500 @enderror"
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

                        <div class="col-span-2 sm:col-span-1">
                            <label for="id_pemasok"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pemasok:</label>
                            <select name="id_pemasok" id="id_pemasok"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('pemasok') border-red-500 @enderror"
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

                        <div class="col-span-2 sm:col-span-1">
                            <label for="h_beli"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga Beli:</label>
                            <input type="number" name="h_beli" id="h_beli"
                                value="{{ old('h_beli', $barang->h_beli) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('h_beli') border-red-500 @enderror"
                                required>
                            @error('h_beli')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="h_jual"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga
                                Jual:</label>
                            <input type="number" name="h_jual" id="h_jual"
                                value="{{ old('h_jual', $barang->h_jual) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('h_jual') border-red-500 @enderror"
                                required>
                            @error('h_jual')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="stok"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok:</label>
                            <input type="text" name="stok" id="stok"
                                value="{{ old('stok', $barang->satuan->nama_satuan == 'Kodi' ? $barang->stok / $barang->satuan->konversi : $barang->stok) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('stok') border-red-500 @enderror"
                                required>
                            {{-- kalau id_satuan nya 2 maka dikonversi ke kodi --}}
                            @error('stok')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="gambar"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar:</label>
                            <input type="file" name="gambar" id="gambar"
                                class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 hover:file:bg-gray-100 @error('gambar') border-red-500 @enderror">
                            @if ($barang->gambar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="Current Image"
                                        width="100">
                                </div>
                            @endif
                            @error('gambar')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>
                    {{-- <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5 me-1 -ms-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add new product
                    </button> --}}
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                        <button type="submit"
                            class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan
                        </button>
                        <div class="mr-2"></div>
                        <button type="reset"
                            class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<script>
    // function updateUkuranAndMotif() {
    //     const kategoriId = document.getElementById('id_kategori').value;

    //     // Fetching the corresponding sizes and motifs based on selected category
    //     fetch(`/getUkuranMotif/${kategoriId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             // Update the Ukuran field (assuming data contains the size information)
    //             document.getElementById('id_ukuran').value = data.ukuran;

    //             // Update the Motif select options
    //             const motifSelect = document.getElementById('id_motif');
    //             motifSelect.innerHTML = ''; // Clear existing options

    //             data.motifs.forEach(motif => {
    //                 const option = document.createElement('option');
    //                 option.value = motif.id_motif;
    //                 option.textContent = motif.nama_motif;
    //                 motifSelect.appendChild(option);
    //             });

    //             // Set the previously selected motif if it matches the current motif
    //             motifSelect.value =
    //             '{{ old('id_motif', $barang->id_motif) }}'; // Ensure this matches your data structure
    //         })
    //         .catch(error => console.error('Error fetching ukuran and motif:', error));
    // }
</script>



{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var kategoriSelect = document.getElementById('id_kategori');
        var ukuranInput = document.getElementById('id_ukuran');
        var motifSelect = document.getElementById('id_motif');

        // Ambil motif dan ukuran yang sudah dipilih sebelumnya dari server-side
        var selectedMotifId = "{{ $barang->id_motif }}"; // Motif yang dipilih sebelumnya
        var selectedUkuran = "{{ $barang->id_ukuran }}"; // Ukuran yang dipilih sebelumnya

        // Fungsi untuk memuat ukuran dan motif berdasarkan kategori yang dipilih
        function loadUkuranAndMotif(idKategori) {
            // Set loading state untuk ukuran input
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

                    // Jika ada ukuran yang sudah dipilih sebelumnya, setel input ukuran
                    if (selectedUkuran) {
                        ukuranInput.value = selectedUkuran;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    ukuranInput.value = 'Error loading data...';
                });

            // Set loading state untuk motif select
            motifSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

            // Fetch Motif berdasarkan kategori
            fetch(`/get-motif/${idKategori}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Data Motif:', data);

                    // Reset opsi motif
                    motifSelect.innerHTML = '<option value="" disabled>Pilih motif...</option>';

                    // Tambahkan opsi motif baru dari hasil query
                    for (const id_motif in data) {
                        const option = document.createElement('option');
                        option.value = id_motif;
                        option.textContent = data[id_motif];

                        // Jika ini adalah motif yang sudah dipilih sebelumnya, set as selected
                        if (id_motif == selectedMotifId) {
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

        // Saat halaman dimuat, ambil kategori yang sudah dipilih dan muat motif dan ukuran
        var initialKategoriId = kategoriSelect.value;
        if (initialKategoriId) {
            loadUkuranAndMotif(initialKategoriId);
        }
    });
</script> --}}
