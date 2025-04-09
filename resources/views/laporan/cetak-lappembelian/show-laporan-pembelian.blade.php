<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pembelian</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
</head>

<body class="bg-gray-100">
    <div class="container p-6 mx-auto">
        <!-- Header Laporan -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Laporan Pembelian</h1>
            <div class="text-sm text-gray-700">
                <div class="p-4 mt-4 text-sm text-gray-700 border border-blue-200 rounded-lg shadow-md bg-blue-50">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center">
                            <i class="mr-2 text-blue-500 fas fa-calendar-alt"></i>
                            <p><strong>Periode:</strong>
                                <span class="text-blue-600">
                                    @if (empty($start2) && empty($end2))
                                        Semua Periode
                                    @else
                                        {{ request('start2') }} - {{ request('end2') }}
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-red-500 fas fa-money-bill-wave"></i>
                            <p><strong class="text-red-500">Total Pengeluaran:</strong> <span
                                    class="text-red-600">{{ number_format($pengeluaran, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        {{-- <div class="flex items-center">
                            <i class="mr-2 text-blue-500 fas fa-check-circle"></i>
                            <p><strong>Status Pembayaran:</strong> <span
                                    class="text-blue-600">{{ request('status') ?? 'Semua Status' }}</span></p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Unduh PDF dan excel -->
        <div class="flex justify-between mb-4">
            <a href="{{ route('laporanpembelian.index') }}"
                class="inline-flex items-center px-4 py-2 font-medium text-white bg-gray-600 rounded-lg shadow-lg hover:bg-gray-700">
                <i class="mr-2 fas fa-arrow-left"></i>Kembali
            </a>
            <div class="flex space-x-2">
                <a href="{{ route('laporanpembelian.exportPDF', ['start2' => request('start2'), 'end2' => request('end2')]) }}"
                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-red-600 rounded-lg shadow-lg hover:bg-red-700">
                    <i class="mr-2 fas fa-file-pdf"></i>Unduh PDF
                </a>

                <a href="{{ route('laporanpembelian.exportXLS', ['start2' => request('start2'), 'end2' => request('end2')]) }}"
                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-green-600 rounded-lg shadow-lg hover:bg-green-700">
                    <i class="mr-2 fas fa-file-excel"></i>Unduh XLS
                </a>
            </div>
        </div>


        <!-- Tabel Laporan pembelian -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="w-full border-collapse table-auto">
                <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase bg-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-center border border-slate-300">No.</th>
                        <th class="px-3 py-3 text-center border border-slate-300">Petugas</th>
                        <th class="px-3 py-3 text-center border border-slate-300">No Pembelian</th>
                        <th class="px-3 py-3 text-center border border-slate-300">Pemasok</th>
                        <th class="px-3 py-3 text-center border border-slate-300">Total</th>
                        <th class="px-3 py-3 text-center border border-slate-300">Tanggal Pembelian</th>
                        <th class="px-3 py-3 text-center border border-slate-300">Waktu Pembelian</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-300">
                    @forelse ($pembelians as $pembelian)
                        <tr class="transition-colors duration-300 ease-in-out hover:bg-gray-100">
                            <td class="px-3 py-4 text-center border border-slate-300">{{ $loop->iteration }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">{{ $pembelian->user->name }}
                            </td>
                            <td class="px-3 py-4 border border-slate-300">{{ $pembelian->nopembelian }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">{{ $pembelian->pemasok->nama }}
                            </td>
                            <td class="px-3 py-4 text-center border border-slate-300">Rp.
                                {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">
                                {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('Y-m-d') }}</td>
                            <td class="px-3 py-4 text-center border border-slate-300">
                                {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"
                                class="px-3 py-4 text-center text-red-700 bg-red-100 border border-red-400">
                                Data Pembelian belum Tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="mt-4">
        {{ $pembelians->appends(request()->input())->links() }}
    </div> --}}
</body>

</html>
