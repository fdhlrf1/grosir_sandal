<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Laporan Penjualan</span>
    </h1>

    <!-- Filter Date Form -->
    <div class="flex items-center mb-3 space-x-4">
        <div id="date-range-picker" date-rangepicker class="flex items-center">
            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <i class="w-4 h-4 text-gray-500 fa-solid fa-calendar dark:text-gray-400" aria-hidden="true"></i>
                </div>
                <input id="datepicker-range-start" name="start" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-477px ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pilih tanggal awal" autocomplete="off" readonly>
            </div>
            <span class="mx-4 text-gray-500">sampai</span>
            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <i class="w-4 h-4 text-gray-500 fa-solid fa-calendar dark:text-gray-400" aria-hidden="true"></i>
                </div>
                <input id="datepicker-range-end" name="end" type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-477px ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pilih tanggal akhir" autocomplete="off" readonly>
            </div>
        </div>


    </div>

    <div class="flex items-center justify-between mb-2">
        <div class="flex space-x-4">
            <button
                class="px-3 text-blue-500 transition-colors border border-blue-500 rounded-md py-5px hover:bg-blue-500 hover:text-white">Filter</button>
            <button
                class="px-3 text-yellow-500 transition-colors border border-yellow-500 rounded-md py-5px hover:bg-yellow-500 hover:text-white">Reset</button>
        </div>

        <div class="flex space-x-4">
            <a href=""
                class="flex items-center px-3 py-2 text-white transition-colors bg-red-500 rounded-md hover:bg-red-600">
                <i class="mr-2 fas fa-file-pdf"></i> Ekspor PDF
            </a>
            {{-- <a href=""
                    class="flex items-center px-3 py-2 text-white transition-colors bg-green-500 rounded-md hover:bg-green-600">
                    <i class="mr-2 fas fa-file-excel"></i> Ekspor Excel
                </a> --}}
        </div>
    </div>


    <!-- Tabel Laporan Penjualan -->
    <div class="max-h-screen overflow-y-auto">
        <table class="w-full mt-4 border-collapse rounded-md shadow-lg table-auto">
            <thead class="text-xs font-medium tracking-wider text-center text-gray-600 uppercase bg-gray-200">
                <tr>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">No
                        Penjualan</th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Nama
                        Konsumen</th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Total
                    </th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Tanggal
                        Pembayaran</th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Waktu
                        Pembayaran</th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Metode
                        Pembayaran</th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Status
                    </th>
                    <th class="px-2 py-3 text-xs font-medium text-center uppercase border border-slate-300">Detail
                    </th>
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
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->bayar }}</td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $penjualan->kembalian }}
                            </td> --}}
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('Y-m-d') }}
                        </td> <!-- Tanggal -->
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('H:i:s') }}
                        </td> <!-- Waktu -->
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $penjualan->metode_pembayaran }}
                        </td>
                        <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">
                            @if (trim($penjualan->status) === 'Belum Lunas')
                                <span
                                    class="flex items-center justify-center px-3 py-2 text-white rounded-lg shadow-md bg-warning">
                                    {{ $penjualan->status }}
                                </span>
                            @else
                                <span
                                    class="flex items-center justify-center px-3 py-2 text-white bg-green-500 rounded-lg shadow-md">
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

</x-layout>

@vite(['resources/js/app.js', 'node_modules/flowbite/dist/flowbite.min.js'])
