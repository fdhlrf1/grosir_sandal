<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container px-0 py-2 mx-auto">
        <h1 class="mb-6 text-2xl font-semibold text-gray-800">
            <span class="text-blue-600">Laporan Penjualan</span>
        </h1>

        <!-- Form Pencarian -->
        <form action="{{ route('penjualan.index') }}" method="GET" class="flex items-center flex-grow">
            <input type="text" name="search" placeholder="Cari penjualan..." value="{{ request()->get('search') }}"
                class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:outline-none w-60">
            <button type="submit"
                class="px-4 py-2 ml-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Cari</button>
            <a href="{{ route('penjualan.index') }}"
                class="px-4 py-2 ml-2 text-white bg-red-500 rounded-md hover:bg-red-600">Reset</a>
        </form>

        <!-- Tabel Laporan Penjualan -->
        <div class="overflow-x-auto">

            <table class="w-full mt-4 overflow-hidden border-collapse rounded-md shadow-lg table-auto">
                <thead class="text-xs font-medium tracking-wider text-center text-gray-600 uppercase bg-gray-200">
                    <tr>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            No Penjualan</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Nama Konsumen</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Total</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Bayar</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Kembalian</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Tanggal Pembayaran</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Waktu Pembayaran</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Metode Pembayaran</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Status</th>
                        <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">
                            Detail</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                {{ $penjualan->nopenjualan }}</td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                {{ $penjualan->konsumen->nama }}</td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->total }}</td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->bayar }}</td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->kembalian }}
                            </td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->tanggal }}
                            </td> <!-- Tanggal -->
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->waktu }}
                            </td>
                            <!-- Waktu -->
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                {{ $penjualan->metode_pembayaran }}
                            </td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                                @if (trim($penjualan->status) === 'Belum Lunas')
                                    <span
                                        class="flex items-center justify-center px-3 py-3 text-white bg-red-500 rounded-lg shadow-md">
                                        {{ $penjualan->status }}
                                    </span>
                                @else
                                    <span
                                        class="flex items-center justify-center px-3 py-3 text-white bg-green-500 rounded-lg shadow-md">
                                        {{ $penjualan->status }}
                                    </span>
                                @endif

                            </td>

                            <td class="px-2 py-4 border border-slate- 300 whitespace-nowrap">
                                <a href="{{ route('penjualan.detail', $penjualan->nopenjualan) }}"
                                    class="flex items-center px-2 py-1 text-blue-600 bg-gray-100 border border-gray-300 rounded-full hover:bg-gray-200">
                                    <i class="mr-2 fas fa-info-circle"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-layout>
