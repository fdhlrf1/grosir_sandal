@foreach ($penjualans as $penjualan)
    @php
        // Ambil detail penjualan berdasarkan nomor penjualan
        $detailPenjualan = $penjualan->detailPenjualan;
    @endphp

    <!-- Modal untuk detail penjualan -->
    <div id="static-modal-detail{{ $penjualan->nopenjualan }}" data-modal-backdrop="static" tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Penjualan : <span class="text-blue-500">{{ $penjualan->nopenjualan }}</span>
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal-detail{{ $penjualan->nopenjualan }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 space-y-4 md:p-5">
                    <!-- Table for detailPenjualan -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-5 py-3 border-b border-gray-200">Kode Barang</th>
                                    {{-- <th class="px-5 py-3 border-b border-gray-200">Satuan</th> --}}
                                    @if (Auth::User()->role->nama_role === 'Admin')
                                        <th class="px-5 py-3 border-b border-gray-200">Harga Beli</th>
                                    @endif
                                    @if (Auth::User()->role->nama_role === 'Admin')
                                        <th class="px-5 py-3 border-b border-gray-200">Harga Jual</th>
                                    @elseif (Auth::User()->role->nama_role === 'Kasir')
                                        <th class="px-5 py-3 border-b border-gray-200">Harga</th>
                                    @endif
                                    <th class="px-5 py-3 border-b border-gray-200">Kuantitas</th>
                                    <th class="px-5 py-3 border-b border-gray-200">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailPenjualan as $detail)
                                    @php
                                        //Ambil satuan dan konversi stok
                                        $satuanNama = $detail->satuan->nama_satuan;
                                        $stokAsli = $detail->qty;

                                        if ($satuanNama === 'Kodi') {
                                            $stokDitampilkan = $stokAsli / $detail->satuan->konversi;
                                        } else {
                                            $stokDitampilkan = $stokAsli;
                                        }
                                    @endphp
                                    <tr class="border-b border-gray-200 dark:border-gray-600">
                                        <td class="px-5 py-4">{{ $detail->kd_barang }}</td>
                                        {{-- <td class="px-5 py-4">{{ $detail->satuan->nama_satuan }}</td> --}}
                                        @if (Auth::User()->role->nama_role === 'Admin')
                                            <td class="px-5 py-4">Rp. {{ number_format($detail->h_beli, 0, ',', '.') }}
                                            </td>
                                        @endif
                                        <td class="px-5 py-4">Rp. {{ number_format($detail->h_jual, 0, ',', '.') }}</td>
                                        <td class="px-5 py-4">{{ $stokDitampilkan }} {{ $detail->satuan->nama_satuan }}
                                        </td>
                                        <td class="px-5 py-4">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Detail Pembayaran</h3>
                            </div>

                            {{-- Tampilkan detail tambahan hanya jika metode pembayaran adalah kredit --}}
                            @if ($penjualan->metode_pembayaran === 'Kredit')
                                <div class="mb-3 space-y-3"> {{-- Jarak antara elemen menggunakan 'space-y-6' --}}
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Metode
                                            Pembayaran:</span>
                                        <span
                                            class="text-sm font-bold text-gray-900 dark:text-white">{{ ucfirst($penjualan->metode_pembayaran) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">DP:</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Rp.
                                            {{ number_format($penjualan->dp, 0, ',', '.') }}</span>
                                    </div>

                                    {{-- Kondisi jika tanggal lunas bernilai null --}}
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                            Lunas:</span>
                                        @if (is_null($penjualan->tanggal_lunas))
                                            <span class="text-sm font-bold text-red-500">Penjualan ini belum
                                                lunas</span>
                                        @else
                                            <span
                                                class="text-sm font-bold text-gray-900 dark:text-white">{{ $penjualan->tanggal_lunas }}</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah
                                            Pelunasan:</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Rp.
                                            {{ number_format($penjualan->jumlah_pelunasan, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sisa:</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Rp.
                                            {{ number_format($penjualan->sisa, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-2 border-b border-gray-300"></div>

                            {{-- Tampilkan informasi total, bayar, dan kembalian --}}
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total:</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">Rp.
                                        {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Bayar:</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">Rp.
                                        {{ number_format($penjualan->bayar, 0, ',', '.') }}</span>
                                </div>
                                @if ($penjualan->metode_pembayaran === 'Tunai')
                                    <div class="flex justify-between">
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">Kembalian:</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">Rp.
                                            {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>



                    </div>
                </div>

                <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                    <button data-modal-hide="static-modal-detail{{ $penjualan->nopenjualan }}" type="button"
                        class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
