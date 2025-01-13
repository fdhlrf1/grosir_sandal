@foreach ($penjualans as $penjualan)
    <!-- Main modal -->
    <div id="static-modal-pelunasan{{ $penjualan->nopenjualan }}" data-modal-backdrop="static" tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <!-- Bagian Judul -->
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Pelunasan : <span class="text-blue-500">{{ $penjualan->nopenjualan }}</span>
                        </h3>
                        <!-- Tombol Close -->
                        <button type="button"
                            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="static-modal-pelunasan{{ $penjualan->nopenjualan }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Keterangan Nama Konsumen -->
                    <!-- Nama Konsumen -->
                    <div class="p-4 mt-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center mb-2">
                            <span class="mr-2 text-gray-700 dark:text-gray-300">
                                <i class="text-blue-500 fas fa-user"></i> <!-- Icon untuk nama konsumen -->
                                Nama Konsumen :
                            </span>
                            <span class="text-lg font-semibold text-yellow-500 dark:text-white">
                                {{ $penjualan->konsumen->nama }}
                            </span>
                        </div>

                        @php
                            // Format tanggal pembayaran dan tanggal jatuh tempo hanya ke "Y-m-d" (tanpa waktu)
                            $tanggal_pembayaran = \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->startOfDay();
                            $tanggal_jatuh_tempo = \Carbon\Carbon::parse($penjualan->tanggal_jatuh_tempo)->startOfDay();
                            $tanggal_sekarang = \Carbon\Carbon::now()->startOfDay();

                            // Hitung selisih hari penuh berdasarkan tanggal jatuh tempo dan hari saat ini
                            $selisih_hari = $tanggal_sekarang->diffInDays($tanggal_jatuh_tempo, false);

                            // Tentukan pesan berdasarkan selisih waktu
                            if ($tanggal_sekarang->greaterThan($tanggal_jatuh_tempo)) {
                                $keterangan = 'Terlambat ' . abs($selisih_hari) . ' hari';
                            } elseif ($tanggal_sekarang->equalTo($tanggal_jatuh_tempo)) {
                                $keterangan = 'Hari ini adalah jatuh tempo';
                            } else {
                                $keterangan = $selisih_hari . ' hari tersisa';
                            }
                        @endphp

                        <div class="flex items-center">
                            <span class="mr-2 text-gray-700 dark:text-gray-300">
                                <i class="text-green-500 fas fa-clock"></i> <!-- Icon untuk waktu pelunasan -->
                                Rentang Waktu Pelunasan :
                            </span>
                            <span class="font-bold text-black dark:text-yellow-400">
                                {{ $keterangan }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Modal body -->

                <form action="{{ route('pelunasan.update', $penjualan->nopenjualan) }}" method="POST"
                    class="p-4 md:p-5">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-3">
                        <div>
                            <label for="total"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total</label>
                            <input type="text" name="total" id="total"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="total pembayaran"
                                value="Rp. {{ number_format($penjualan->total, 0, ',', '.') }}" readonly>
                        </div>
                        <div>
                            <label for="dp"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DP
                            </label>
                            <input type="text" name="dp" id="dp"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="dp pembayaran" value="Rp. {{ number_format($penjualan->dp, 0, ',', '.') }}"
                                readonly>
                        </div>
                        <div>
                            <label for="sisa"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sisa</label>
                            <input type="text" name="sisa" id="sisa"
                                class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="sisa pembayaran"
                                value="Rp. {{ number_format($penjualan->sisa, 0, ',', '.') }}" readonly>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2">
                            <label for="jumlah_pelunasan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                Pelunasan</label>
                            <input type="text" name="jumlah_pelunasan" id="jumlah_pelunasan"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('jumlah_pelunasan') border-red-500 @enderror"
                                placeholder="Contoh: Rp. 50.000" oninput="formatRupiah(this)" required>
                            @error('jumlah_pelunasan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>



                        {{-- <input type="text" name="tanggal_pembayaran" id="tanggal_pembayaran"
                            value="{{ $penjualan->tanggal_pembayaran }}"> --}}

                        <input type="hidden" name="tanggal_pembayaran[]"
                            id="tanggal_pembayaran_{{ $penjualan->nopenjualan }}"
                            value="{{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('Y-m-d') }}">


                        <div class="col-span-2">
                            <label for="tanggal_lunas_{{ $penjualan->nopenjualan }}"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                Pelunasan</label>
                            {{-- <input type="date" name="tanggal_lunas" value="{{ old('tanggal_lunas') }}"> --}}

                            <input type="date" name="tanggal_lunas[]"
                                id="tanggal_lunas_{{ $penjualan->nopenjualan }}"
                                class="tanggal_lunas bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('tanggal_lunas') border-red-500 @enderror"
                                placeholder="tanggal pelunasan" required="">
                            @error('tanggal_lunas')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-between p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                        <div class="flex justify-end w-full space-x-3">
                            <button type="submit"
                                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Proses Pelunasan</button>
                            <button data-modal-hide="static-modal-pelunasan{{ $penjualan->nopenjualan }}"
                                type="button"
                                class="px-4 py-2 ml-4 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Batal</button>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    </form>
@endforeach

<script>
    function formatRupiah(angka, input) {
        let number_string = angka.replace(/[^,\d]/g, '').toString();
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        input.value = 'Rp. ' + rupiah;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalPembayaranElements = document.querySelectorAll('[id^="tanggal_pembayaran_"]');

        tanggalPembayaranElements.forEach(function(tanggalPembayaran) {
            const nopenjualan = tanggalPembayaran.id.split('_')[2]; // Dapatkan indeks dari ID
            const tanggalLunas = document.getElementById(`tanggal_lunas_${nopenjualan}`);
            const initialDate = tanggalPembayaran.value;
            tanggalLunas.setAttribute('min', initialDate); // Atur tanggal min saat muat

            tanggalPembayaran.addEventListener('change', function() {
                const selectedDate = this.value;
                tanggalLunas.setAttribute('min',
                    selectedDate); // Perbarui tanggal min saat berubah
            });
        });
    });
</script>
