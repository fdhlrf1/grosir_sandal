@foreach ($pembelians as $pembelian)
    @php
        // Ambil detail pembelian berdasarkan nomor pembelian
        $detailPembelian = $pembelian->detailPembelian;
    @endphp

    <!-- Modal untuk detail pembelian -->
    <div id="static-modal-detail2{{ $pembelian->nopembelian }}" data-modal-backdrop="static" tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Pembelian : <span class="text-blue-500">{{ $pembelian->nopembelian }}</span>
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal-detail2{{ $pembelian->nopembelian }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 space-y-4 md:p-5">
                    <!-- Table for detailpembelian -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-5 py-3 border-b border-gray-200">Kode Barang</th>
                                    {{-- <th class="px-5 py-3 border-b border-gray-200">Satuan</th> --}}
                                    @if (Auth::User()->role->nama_role === 'Admin')
                                        <th class="px-5 py-3 border-b border-gray-200">Harga</th>
                                    @endif
                                    <th class="px-5 py-3 border-b border-gray-200">Kuantitas</th>
                                    <th class="px-5 py-3 border-b border-gray-200">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailPembelian as $detail)
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
                                        {{-- <td class="px-5 py-4">{{ $detail->pemasok->nama }}</td> --}}
                                        {{-- <td class="px-5 py-4">{{ $detail->satuan->nama_satuan }}</td> --}}
                                        @if (Auth::User()->role->nama_role === 'Admin')
                                            <td class="px-5 py-4">Rp. {{ number_format($detail->h_beli, 0, ',', '.') }}
                                            </td>
                                        @endif
                                        {{-- <td class="px-5 py-4">Rp. {{ number_format($detail->h_jual, 0, ',', '.') }}</td> --}}
                                        <td class="px-5 py-4">{{ $stokDitampilkan }} {{ $detail->satuan->nama_satuan }}
                                        </td>
                                        <td class="px-5 py-4">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                    <button data-modal-hide="static-modal-detail2{{ $pembelian->nopembelian }}" type="button"
                        class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
