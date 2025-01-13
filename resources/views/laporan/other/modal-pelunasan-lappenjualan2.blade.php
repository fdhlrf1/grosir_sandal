@foreach ($penjualans as $penjualan)
    <!-- Modal Content -->
    <div id="static-modal-pelunasan{{ $penjualan->nopenjualan }}" ...>
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pelunasan</h3>
                        <button type="button" class="...">Close modal</button>
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-700 dark:text-gray-300">Nama Konsumen: </span>
                        <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $penjualan->konsumen->nama }}</span>
                    </div>
                </div>

                <form action="{{ route('pelunasan.update', $penjualan->nopenjualan) }}" method="POST"
                    class="p-4 md:p-5">
                    @csrf
                    @method('PUT')

                    <!-- Input Fields -->
                    <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-3">
                        <div>
                            <label for="total" class="...">Total</label>
                            <input type="text" name="total" id="total" class="..."
                                value="Rp. {{ number_format($penjualan->total, 0, ',', '.') }}" readonly>
                        </div>
                        <div>
                            <label for="dp" class="...">DP</label>
                            <input type="text" name="dp" id="dp" class="..."
                                value="Rp. {{ number_format($penjualan->dp, 0, ',', '.') }}" readonly>
                        </div>
                        <div>
                            <label for="sisa" class="...">Sisa</label>
                            <input type="text" name="sisa" id="sisa" class="..."
                                value="Rp. {{ number_format($penjualan->sisa, 0, ',', '.') }}" readonly>
                        </div>
                    </div>



                    <div class="col-span-2">
                        <label for="tanggal_lunas_{{ $penjualan->nopenjualan }}" class="...">Tanggal
                            Pelunasan</label>
                        <input type="date" name="tanggal_lunas[]" id="tanggal_lunas_{{ $penjualan->nopenjualan }}"
                            class="tanggal_lunas bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg ...">
                        @error('tanggal_lunas')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                        <button data-modal-hide="static-modal-pelunasan{{ $penjualan->nopenjualan }}" type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 ...">Proses Pelunasan</button>
                        <button data-modal-hide="static-modal-pelunasan{{ $penjualan->nopenjualan }}" type="button"
                            class="...">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
