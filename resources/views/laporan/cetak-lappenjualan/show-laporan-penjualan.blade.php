<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="container p-6 mx-auto">
        <!-- Header Laporan -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Laporan Penjualan</h1>
            <div class="text-sm text-gray-700">
                <div class="p-4 mt-4 text-sm text-gray-700 border border-blue-200 rounded-lg shadow-md bg-blue-50">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center">
                            <i class="mr-2 text-blue-500 fas fa-calendar-alt"></i>
                            <p><strong>Periode:</strong>
                                <span class="text-blue-600">
                                    @if (empty($start) && empty($end) && empty($metode) && empty($status))
                                        Semua Periode
                                    @else
                                        {{ request('start') }} - {{ request('end') }}
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-blue-500 fas fa-credit-card"></i>
                            <p><strong>Metode Pembayaran:</strong> <span
                                    class="text-blue-600">{{ request('metode_pembayaran') ?? 'Semua Metode' }}</span>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-blue-500 fas fa-check-circle"></i>
                            <p><strong>Status Pembayaran:</strong> <span
                                    class="text-blue-600">{{ request('status') ?? 'Semua Status' }}</span></p>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-green-500 fas fa-money-bill-wave"></i>
                            <p><strong class="text-green-500">Total Pendapatan:</strong> <span
                                    class="text-green-600">Rp.
                                    {{ number_format($pendapatan, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Unduh PDF dan excel -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('laporanpenjualan.index') }}"
                class="inline-flex items-center px-4 py-2 font-medium text-white bg-gray-600 rounded-lg shadow-lg hover:bg-gray-700">
                <i class="mr-2 fas fa-arrow-left"></i>Kembali
            </a>
            <div class="flex space-x-2">
                <a href="{{ route('laporanpenjualan.exportPDF', ['start' => request('start'), 'end' => request('end'), 'metode_pembayaran' => request('metode_pembayaran'), 'status' => request('status')]) }}"
                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-red-600 rounded-lg shadow-lg hover:bg-red-700">
                    <i class="mr-2 fas fa-file-pdf"></i>Unduh PDF
                </a>

                <a href="{{ route('laporanpenjualan.exportXLS', ['start' => request('start'), 'end' => request('end'), 'metode_pembayaran' => request('metode_pembayaran'), 'status' => request('status')]) }}"
                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-green-600 rounded-lg shadow-lg hover:bg-green-700">
                    <i class="mr-2 fas fa-file-excel"></i>Unduh XLS
                </a>
            </div>
        </div>


        <!-- Tombol Kembali -->
        {{-- <div class="flex mb-4">

        </div> --}}

        <!-- Tabel Laporan Penjualan -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="w-full border-collapse table-auto">
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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($penjualans as $penjualan)
                        <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                            <td class="px-3 py-4 text-center border border-slate-300">{{ $loop->iteration }}</td>
                            <td class="px-3 py-4 border text-center border-slate-300">{{ $penjualan->user->name }}</td>
                            <td class="px-3 py-4 border text-center border-slate-300">{{ $penjualan->nopenjualan }}
                            </td>
                            <td class="px-3 py-4 text-center border border-slate-300">{{ $penjualan->konsumen->nama }}
                            </td>
                            <td class="px-3 py-4 text-center border border-slate-300">Rp.
                                {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">
                                {{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('Y-m-d') }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">
                                {{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('H:i:s') }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">
                                {{ $penjualan->metode_pembayaran }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">
                                @if (trim($penjualan->status) === 'Belum Lunas')
                                    <span
                                        class="flex items-center justify-center px-3 py-2 text-white bg-red-500 rounded-lg">
                                        <span>Belum Lunas</span>
                                    </span>
                                @else
                                    <span
                                        class="flex items-center justify-center px-3 py-2 text-white bg-green-500 rounded-lg">
                                        {{ $penjualan->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                                Data Penjualan belum Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="mt-4">
        {{ $penjualans->appends(request()->input())->links() }}
    </div> --}}
</body>

</html>
