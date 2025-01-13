<!-- Modal2 -->
<div id="modal2"
    class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 ease-in-out transform scale-95 bg-gray-900 bg-opacity-50 opacity-0">
    <div class="w-11/12 max-w-6xl max-h-screen p-6 overflow-y-auto bg-white rounded-md">
        <h3 class="mb-4 text-xl font-semibold">Pilih Barang atau tambahkan yang baru</h3>
        <table class="w-full overflow-hidden border-collapse rounded-sm shadow-lg table-auto">
            <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
                <tr>
                    <th class="px-3 py-3 border border-slate-300">No.</th>
                    <th class="px-6 py-3 border border-slate-300">Gambar</th>
                    <th class="px-3 py-3 border border-slate-300">Kategori Barang</th>
                    <th class="px-3 py-3 border border-slate-300">Kode Barang</th>
                    <th class="px-3 py-3 border border-slate-300">Warna</th>
                    <th class="px-3 py-3 border border-slate-300">Motif</th>
                    <th class="px-3 py-3 border border-slate-300">Size</th>
                    <th class="px-3 py-3 border border-slate-300">Stok</th>
                    <th class="px-3 py-3 border border-slate-300">Pemasok</th>
                    <th class="px-3 py-3 border border-slate-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($barangs as $barang)
                    @php
                        //Ambil satuan dan konversi stok
                        $satuanNama = $barang->satuan->nama_satuan;
                        $stokAsli = $barang->stok;
                        if ($stokAsli == 0) {
                            $stokDitampilkan = 'Stok Habis';
                        } else {
                            if ($satuanNama === 'Kodi') {
                                $stokDitampilkan = $stokAsli / $barang->satuan->konversi;
                            } else {
                                $stokDitampilkan = $stokAsli;
                            }
                        }
                    @endphp
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">{{ $loop->iteration }}
                        </td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">
                            @if ($barang->gambar)
                                <img src="{{ asset('storage/barang/' . $barang->gambar) }}" alt="{{ $barang->nama }}"
                                    class="object-cover rounded-md shadow-md h-28 w-28">
                            @else
                                <span class="italic text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $barang->kategori->nama ?? 'N/A' }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $barang->kd_barang }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $barang->warna }}</td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $barang->motif->nama_motif }}</td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $barang->size }}</td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            @if ($stokAsli == 0)
                                <span class="px-2 py-1 text-red-700 bg-red-100 rounded">Stok Habis</span>
                            @else
                                {{ $stokDitampilkan }} {{ $satuanNama }}
                            @endif
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $barang->pemasok->nama }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            <button type="button"
                                class="px-4 py-2 text-white bg-blue-500 rounded select-barang hover:bg-blue-600"
                                data-id="{{ $barang->id }}" data-kode="{{ $barang->kd_barang }}"
                                data-kategori="{{ $barang->kategori->nama ?? 'N/A' }}"
                                data-motif="{{ $barang->motif->nama_motif }}" data-size="{{ $barang->size }}"
                                data-warna="{{ $barang->warna }}" data-satuan="{{ $barang->satuan->nama_satuan }}"
                                data-pemasok="{{ $barang->pemasok->nama }}" data-h_beli="{{ $barang->h_beli }}"
                                data-h_jual="{{ $barang->h_jual }}" data-gambar="{{ $barang->gambar }}"
                                data-stok="{{ $stokDitampilkan }} {{ $satuanNama }}">Pilih</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Produk belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="flex justify-end mt-4">
            <button id="closeModal2" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Tutup</button>
        </div>
    </div>
</div>
