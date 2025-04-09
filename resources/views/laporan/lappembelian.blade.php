<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container px-0 py-2 mx-auto">
        <h1 class="pb-2 mb-4 text-2xl font-semibold text-gray-800 border-b-2 border-gray-300">
            <span class="text-blue-600">Laporan Pembelian</span>
        </h1>

        @include('laporan.modal-detail-lappembelian')


        <!-- Filter Date Form -->
        <form action="{{ route('laporanpembelian.filter') }}" method="GET">
            <div class="flex items-center mb-3 space-x-4">
                <div id="date-range-picker" date-rangepicker class="flex items-center">
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <i class="w-4 h-4 text-gray-500 fa-solid fa-calendar dark:text-gray-400"
                                aria-hidden="true"></i>
                        </div>
                        <input id="datepicker-range-start" name="start2" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-469px ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Pilih tanggal awal" autocomplete="off" value="{{ request()->get('start2') }}"
                            readonly>
                    </div>
                    <span class="mx-4 text-gray-500">sampai</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <i class="w-4 h-4 text-gray-500 fa-solid fa-calendar dark:text-gray-400"
                                aria-hidden="true"></i>
                        </div>
                        <input id="datepicker-range-end" name="end2" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-469px ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Pilih tanggal akhir" autocomplete="off" value="{{ request()->get('end2') }}"
                            readonly>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex space-x-4">
                    <button type="submit"
                        class="px-3 text-blue-500 transition-colors border border-blue-500 rounded-md py-5px hover:bg-blue-500 hover:text-white">Filter</button>
                    <a href="{{ route('laporanpembelian.index') }}"
                        class="px-3 text-yellow-400 transition-colors border border-yellow-400 rounded-md py-5px hover:bg-yellow-400 hover:text-white">
                        Reset
                    </a>

                </div>
        </form>
        @if (Auth::User()->role->nama_role === 'Admin')
            <div class="flex space-x-4">
                <a href="{{ route('laporanpembelian.show', ['start2' => request('start2'), 'end2' => request('end2')]) }}"
                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700">
                    <i class="mr-2 fas fa-file-export"></i> Ekspor
                </a>
                {{-- <a href=""
                class="flex items-center px-3 py-2 text-white transition-colors bg-red-500 rounded-md hover:bg-red-600">
                <i class="mr-2 fas fa-file-pdf"></i> Ekspor PDF
            </a>
            <a href=""
                class="flex items-center px-3 py-2 text-white transition-colors bg-green-500 rounded-md hover:bg-green-600">
                <i class="mr-2 fas fa-file-excel"></i> Ekspor Excel
            </a> --}}
            </div>
        @endif
    </div>



    <!-- Tabel Laporan Pembelian -->
    <div class="overflow-x-auto">
        <table class="w-full overflow-hidden border-collapse rounded-md shadow-lg table-auto">
            <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
                <tr>
                    <th class="px-3 py-3 text-center border border-slate-300">No.</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Petugas</th>
                    <th class="px-3 py-3 text-center border border-slate-300">No Pembelian</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Pemasok</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Total</th>
                    {{-- <th class="px-3 py-3 text-center border border-slate-300">
                            Bayar</th> --}}
                    {{-- <th class="px-3 py-3 text-center border border-slate-300">
                            Kembalian</th> --}}
                    <th class="px-3 py-3 text-center border border-slate-300">Tanggal Pembelian</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Waktu Pembelian</th>
                    <th class="px-3 py-3 text-center border border-slate-300">Detail</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @forelse ($pembelians as $pembelian)
                    <tr>
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ $loop->iteration + $pembelians->firstItem() - 1 }}</td>
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ $pembelian->user->name }}</td>
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ $pembelian->nopembelian }}</td>
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ $pembelian->pemasok->nama }}</td>
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            Rp. {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                        {{-- <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $pembelian->bayar }}</td>
                            <td class="px-2 py-4 border border-slate-300 whitespace-nowrap">{{ $pembelian->kembalian }}
                            </td> --}}
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('Y-m-d') }}
                        </td> <!-- Tanggal -->
                        <td class="px-3 py-4 text-center border border-slate-300 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('H:i:s') }}
                        </td> <!-- Waktu -->

                        <td class="px-2 py-4 text-center border border-slate-300 whitespace-nowrap">
                            <div class="flex justify-center">
                                <button data-modal-target="static-modal-detail2{{ $pembelian->nopembelian }}"
                                    data-modal-toggle="static-modal-detail2{{ $pembelian->nopembelian }}"
                                    type="button"
                                    class="flex items-center px-4 py-1 text-blue-600 bg-gray-100 border border-gray-300 rounded-full hover:bg-gray-200">
                                    <i class="mr-2 fas fa-info-circle"></i> Detail
                                </button>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                            Data Pembelian belum Tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $pembelians->appends(request()->input())->links() }}
    </div>

</x-layout>
<x-modal-flowbite></x-modal-flowbite>
