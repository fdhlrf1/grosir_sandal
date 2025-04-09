<!-- resources/views/datautama/d_kategori.blade.php -->
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h1 class="pb-2 mb-4 text-2xl font-medium text-gray-800 border-b-2 border-gray-300">
        <span class="text-blue-600">Laporan Penjualan</span>
    </h1>

    <link rel="stylesheet" href="{{ mix('app/css/style.css') }}">

    @include('laporan.modal-detail-lappenjualan')
    @include('laporan.modal-pelunasan')

    <form action="{{ route('laporanpenjualan.filter') }}" method="GET">
        <div class="flex items-center mb-3 space-x-4">
            <div id="date-range-picker" date-rangepicker class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <i class="w-4 h-4 text-gray-500 fa-solid fa-calendar dark:text-gray-400" aria-hidden="true"></i>
                    </div>
                    <input id="datepicker-range-start" name="start" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-502px ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Pilih tanggal awal" autocomplete="off" value="{{ request()->get('start') }}"
                        required readonly>
                </div>
                {{-- <span class="mx-4 text-gray-500">sampai</span> --}}
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <i class="w-4 h-4 text-gray-500 fa-solid fa-calendar dark:text-gray-400" aria-hidden="true"></i>
                    </div>
                    <input id="datepicker-range-end" name="end" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-502px ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Pilih tanggal akhir" autocomplete="off" value="{{ request()->get('end') }}"required
                        readonly>
                </div>
            </div>
        </div>

        <div class="flex items-center mb-3 space-x-4">
            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <i class="w-4 h-4 text-gray-500 fa-solid fa-wallet" aria-hidden="true"></i>
                </div>
                <select
                    class="px-10 py-2 mr-0 text-sm border border-gray-300 rounded-md bg-gray-50 w-502px focus:outline-none focus:border-blue-500"
                    name="metode_pembayaran">
                    <option value="" disabled selected class="text-sm">Metode Pembayaran</option>
                    <option value="Kredit" class="text-sm"
                        {{ request()->get('metode_pembayaran') == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                    <option value="Tunai" class="text-sm"
                        {{ request()->get('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                </select>
            </div>

            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <i class="w-4 h-4 text-gray-500 fa-solid fa-hourglass-half" aria-hidden="true"></i>
                </div>
                <select
                    class="px-10 py-2 mr-0 text-sm border border-gray-300 rounded-md bg-gray-50 w-502px focus:outline-none focus:border-blue-500"
                    name="status">
                    <option value="" class="text-sm" disabled selected>Status</option>
                    <option value="Lunas" class="text-sm" {{ request()->get('status') == 'Lunas' ? 'selected' : '' }}>
                        Lunas
                    </option>
                    <option value="Belum Lunas" class="text-sm"
                        {{ request()->get('status') == 'Belum Lunas' ? 'selected' : '' }}>
                        Belum Lunas</option>
                </select>
            </div>
        </div>

        {{-- {{ $pendapatan }} --}}

        <div class="flex items-center justify-between mb-4">
            <div class="flex space-x-4">
                <button type="submit"
                    class="px-3 text-blue-500 transition-colors border border-blue-500 rounded-md py-5px hover:bg-blue-500 hover:text-white">Filter
                </button>
                <a href="{{ route('laporanpenjualan.index') }}"
                    class="px-3 text-yellow-400 transition-colors border border-yellow-400 rounded-md py-5px hover:bg-yellow-400 hover:text-white">
                    Reset
                </a>

            </div>

            @if (Auth::User()->role->nama_role === 'Admin')
                <div class="flex space-x-4">
                    <a href="{{ route('laporanpenjualan.show', ['start' => request('start'), 'end' => request('end'), 'metode_pembayaran' => request('metode_pembayaran'), 'status' => request('status')]) }}"
                        class="inline-flex items-center px-4 py-2 font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700">
                        <i class="mr-2 fas fa-file-export"></i> Ekspor
                    </a>
                    {{-- <a href="{{ route('laporanpenjualan.showPDF', ['start' => request('start'), 'end' => request('end'), 'metode_pembayaran' => request('metode_pembayaran'), 'status' => request('status')]) }}"
                    class="flex items-center px-3 py-2 text-white transition-colors bg-red-500 rounded-md hover:bg-red-600">
                    <i class="mr-2 fas fa-file-pdf"></i> Ekspor PDF
                </a> --}}
                    {{-- <a href=""
                    class="flex items-center px-3 py-2 text-white transition-colors bg-green-500 rounded-md hover:bg-green-600">
                    <i class="mr-2 fas fa-file-excel"></i> Ekspor Excel
                </a> --}}
                </div>
            @endif
        </div>

    </form>


    <div class="overflow-x-auto">
        <table class="w-full overflow-hidden border-collapse rounded-lg shadow-lg table-auto">
            <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
                <tr>
                    <th class="px-3 py-3 text-center border border-slate-300">No.</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Petugas</th>
                    <th class="px-3 py-3 text-center border border-slate-300">No Penjualan</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Nama Konsumen</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Total</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Tanggal Pembayaran</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Waktu Pembayaran</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Metode Pembayaran</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Status</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Detail</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($penjualans as $penjualan)
                    <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ $loop->iteration + $penjualans->firstItem() - 1 }}
                        </td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $penjualan->user->name }}
                        </td>
                        <td class="px-3 py-4 border border-slate-300 whitespace-nowrap">
                            {{ $penjualan->nopenjualan }}
                        </td>
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ $penjualan->konsumen->nama }}
                        </td>
                        <td class="w-64 px-3 py-8 text-center border whitespace-nowrap border-slate-300">
                            Rp. {{ number_format($penjualan->total, 0, ',', '.') }}
                        </td>
                        {{-- <td class="w-64 px-3 py-8 text-center whitespace-normal border border-slate-300">
                            {{ $penjualan->tanggal_pembayaran }}
                        </td> --}}
                        <td class="w-64 px-3 py-8 text-center whitespace-normal border border-slate-300">
                            {{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('Y-m-d') }}
                        </td>
                        <td class="w-64 px-3 py-8 text-center whitespace-normal border border-slate-300">
                            {{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('H:i:s') }}
                        </td>
                        <td class="w-64 px-3 py-8 text-center whitespace-normal border border-slate-300">
                            {{ $penjualan->metode_pembayaran }}
                        </td>
                        <td class="w-64 px-3 py-8 text-center whitespace-normal border border-slate-300">
                            @if (trim($penjualan->status) === 'Belum Lunas')
                                <span data-modal-target="static-modal-pelunasan{{ $penjualan->nopenjualan }}"
                                    data-modal-toggle="static-modal-pelunasan{{ $penjualan->nopenjualan }}"
                                    class="flex items-center justify-center px-3 py-2 text-white bg-red-500 rounded-lg shadow-md cursor-pointer">
                                    <span class="mr-1">Belum</span>
                                    <span>Lunas</span>
                                </span>
                            @else
                                <span
                                    class="flex items-center justify-center px-3 py-2 text-white bg-green-500 rounded-lg shadow-md">
                                    {{ $penjualan->status }}
                                </span>
                            @endif
                        </td>

                        <td class="w-64 px-3 py-8 whitespace-normal border border-slate-300">
                            <button data-modal-target="static-modal-detail{{ $penjualan->nopenjualan }}"
                                data-modal-toggle="static-modal-detail{{ $penjualan->nopenjualan }}" type="button"
                                class="flex items-center px-4 py-1 text-blue-600 bg-gray-100 border border-gray-300 rounded-full hover:bg-gray-200">
                                <i class="mr-2 fas fa-info-circle"></i> Detail</button>

                            {{-- <a href="{{ route('penjualan.detail', $penjualan->nopenjualan) }}"
                                class="flex items-center px-2 py-1 text-blue-600 bg-gray-100 border border-gray-300 rounded-full hover:bg-gray-200">
                                <i class="mr-2 fas fa-info-circle"></i> Detail
                            </a> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9"
                            class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Penjualan belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $penjualans->appends(request()->input())->links() }}
    </div>
</x-layout>
<x-modal-flowbite></x-modal-flowbite>
