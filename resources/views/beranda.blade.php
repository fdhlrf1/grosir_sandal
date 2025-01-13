<x-layout>

    <style>
        /* .informasipelanggan::-webkit-scrollbar {
            display: none;
        } */
        .informasipelanggan::-webkit-scrollbar {
            height: 12px;
        }

        .informasipelanggan::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 10px;
        }

        .informasipelanggan::-webkit-scrollbar-thumb {
            background-color: #dbdbdb;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
        }

        .informasipelanggan::-webkit-scrollbar-thumb:hover {
            transition: 1s;
            background-color: #CCCCCC
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container mx-auto">
        @if (Auth::User()->role->nama_role === 'Admin')
            <div class="grid grid-cols-3 gap-4 mb-6">
                <!-- Data Penjualan -->
                <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                    <div class="flex items-center">
                        <i class="text-3xl text-purple-500 fas fa-tags"></i>
                        <div class="ml-3">
                            <h2 class="text-xl font-semibold text-gray-800">Data Penjualan</h2>
                            <p class="text-2xl font-bold text-gray-900">{{ $tDataPenjualanBulanIni }}</p>
                            <p class="text-sm text-blue-500">↑ {{ $persentaseKenaikanPenjualan }}% Dibandingkan bulan
                                lalu</p>
                        </div>
                    </div>
                </div>

                <!-- Total Pendapatan (Admin Only) -->
                <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                    <div class="flex items-center">
                        <i class="text-3xl text-blue-500 fas fa-file-invoice-dollar"></i>
                        <div class="ml-3">
                            <h2 class="text-xl font-semibold text-gray-800">Total Pendapatan</h2>
                            <p class="text-2xl font-bold text-gray-900">Rp.
                                {{ number_format($tPenjualanBulanIni, 0, ',', '.') }}</p>
                            <p class="text-sm text-blue-500">↑ {{ $persentaseKenaikanPendapatan }}% Dibandingkan bulan
                                lalu</p>
                        </div>
                    </div>
                </div>

                <!-- Total Pengeluaran (Admin Only) -->
                <div class="p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                    <div class="flex items-center">
                        <i class="text-3xl fas fa-paper-plane text-cyan-500"></i>
                        <div class="ml-3">
                            <h2 class="text-xl font-semibold text-gray-800">Total Pengeluaran</h2>
                            <p class="text-2xl font-bold text-gray-900">Rp.
                                {{ number_format($tPembelianBulanIni, 0, ',', '.') }}</p>
                            <p class="text-sm text-blue-500">↑ {{ $persentaseKenaikanPembelian }}% Dibandingkan bulan
                                lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 mb-6">
            <!-- Data Penjualan -->
            <div class="flex items-center justify-between p-4 bg-gray-100 border border-gray-100 rounded-lg shadow">
                <!-- Bagian Kiri: Informasi Utama -->
                <div class="flex items-center space-x-4">
                    <i class="text-3xl text-green-500 fas fa-hand-holding-usd"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Total Penjualan Hari Ini</h2>
                        <p class="text-2xl font-bold text-gray-900">{{ $tTransaksiHariIni }} Transaksi</p>
                        <div class="mt-2 space-y-1 text-gray-700">
                            <p>Total Pendapatan Hari Ini: <span class="font-semibold text-green-500">Rp.
                                    {{ number_format($tPendapatanHariIni, 0, ',', '.') }}</span></p>
                            <p>Jumlah Barang Terjual: <span class="font-semibold text-purple-500">{{ $tBarangTerjual }}
                                    Pcs</span></p>
                        </div>
                    </div>
                </div>
                <!-- Bagian Kanan: Riwayat Transaksi Terbaru -->
                <div class="flex justify-end">
                    <div class="mr-0 text-right">
                        <p class="font-semibold text-gray-800 mr-9">Riwayat Transaksi Terbaru:</p>
                        <table class="mt-0">
                            <tbody>
                                @forelse ($transaksiTerbaru as $transaksi)
                                    <tr>
                                        <td class="px-1 py-1 font-semibold text-blue-600">
                                            #{{ $transaksi->nopenjualan }} -</td>
                                        <td class="px-1 py-1 font-semibold text-left text-green-600">Rp.
                                            {{ number_format($transaksi->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-2 text-center text-gray-500">Tidak ada
                                            transaksi terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        {{-- @endif --}}

        <!-- Informasi Pelanggan dengan Kredit Aktif -->
        <div
            class="p-4 mb-4 w-[1021px] overflow-x-auto bg-gray-100 border border-gray-100 rounded-lg shadow informasipelanggan">
            <div class="flex items-center">
                <i class="text-3xl text-red-500 fas fa-user-clock"></i>
                <div class="ml-3">
                    <h2 class="text-xl font-semibold text-gray-800">Pelanggan Belum Lunas</h2>
                    <ul class="flex mt-2 space-x-10 overflow-x-auto text-gray-700">
                        @forelse ($kreditAktif as $pelanggan)
                            <li class="flex flex-col mb-2 min-w-max">
                                <span class="font-bold">{{ $pelanggan->konsumen->nama }}</span>
                                <span class="flex text-sm">Sisa Kredit:
                                    <span class="ml-1 font-semibold text-yellow-500">Rp.
                                        {{ number_format($pelanggan->sisa, 0, ',', '.') }}</span>
                                </span>
                                <span class="flex text-sm text-blue-500">Jatuh Tempo:
                                    <span class="ml-1 font-semibold">{{ $pelanggan->tanggal_jatuh_tempo }}</span>
                                </span>
                            </li>
                        @empty
                            <li class="text-gray-500">Tidak ada pelanggan dengan kredit aktif.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>


    </div>

    <!-- Charts Section -->
    <div class="flex">
        @if (Auth::User()->role->nama_role === 'Admin')
            <!-- Chart Pendapatan  -->
            <div
                class="w-3/5 p-6 mb-4 mr-4 transition-transform transform bg-white border border-gray-100 rounded-lg shadow-lg">
                <h2 class="flex items-center mb-4 text-xl font-semibold text-gray-800">
                    <i class="mr-2 text-3xl text-blue-500 fas fa-chart-line"></i>
                    Chart Pendapatan
                </h2>
                {!! $chart->container() !!}
            </div>
        @endif

        <div
            class="{{ Auth::User()->role->nama_role === 'Admin' ? 'w-3/6' : 'w-full' }} p-6 mb-4 transition-transform transform bg-white border border-gray-100 rounded-lg shadow-lg">
            <h2 class="flex items-center mb-4 text-xl font-semibold text-gray-800">
                <i class="mr-2 text-3xl text-blue-500 fas fa-chart-line"></i>
                Chart Barang
            </h2>
            {!! $chartbarang->container() !!}
        </div>

    </div>
    </div>

    <!-- Chart Scripts -->
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    <script src="{{ $chartbarang->cdn() }}"></script>
    {{ $chartbarang->script() }}
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}


</x-layout>
