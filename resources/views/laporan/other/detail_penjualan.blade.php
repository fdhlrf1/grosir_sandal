<x-layout>
    <x-slot:title>Detail Penjualan - {{ $penjualan->nopenjualan }}</x-slot:title>
    <div class="container px-0 py-2 mx-auto">
        <h1 class="mb-6 text-2xl font-semibold text-gray-800">
            <span class="text-blue-600">Detail Penjualan: {{ $penjualan->nopenjualan }}</span>
        </h1>

        <!-- Detail Penjualan -->
        <div class="overflow-x-auto">
            <table class="w-full mb-5 overflow-hidden border-collapse rounded-md shadow-sm table-auto">
                <thead class="text-xs font-medium tracking-wider text-center text-gray-600 uppercase bg-gray-200">
                    <tr>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Kode Barang</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Satuan</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Harga Beli</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Harga Jual</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Kuantitas</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($detailPenjualan as $detail)
                        <tr>
                            <td class="px-5 py-4 border border-slate-300 whitespace-nowrap">{{ $detail->kd_barang }}
                            </td>
                            <td class="px-5 py-4 border border-slate-300 whitespace-nowrap">
                                {{ $detail->satuan->nama_satuan }}</td>
                            <td class="px-5 py-4 border border-slate-300 whitespace-nowrap">{{ $detail->h_beli }}</td>
                            <td class="px-5 py-4 border border-slate-300 whitespace-nowrap">{{ $detail->h_jual }}</td>
                            <td class="px-5 py-4 border border-slate-300 whitespace-nowrap">{{ $detail->qty }}</td>
                            <td class="px-5 py-4 border border-slate-300 whitespace-nowrap">{{ $detail->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tautan kembali ke laporan penjualan -->
        <a href="{{ route('laporanpenjualan.index') }}"
            class="px-4 py-2 font-semibold text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none ">Kembali
        </a>


    </div>
</x-layout>
