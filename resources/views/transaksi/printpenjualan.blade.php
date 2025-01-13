<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembayaran</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('node_modules/flowbite/dist/flowbite.css') }}" rel="stylesheet">
    <style>
        @media print {

            /* Hide print button and body when printing */
            button,
            .gambar,
            .print,
            body,
            .kembali {
                display: none;
            }

            .fa-print {
                display: none;
            }
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <button onclick="window.print();"
        class="fixed bg-[#719192] p-2 rounded top-[2%] right-[2%] flex items-center hover:bg-[#5f7a7a]">
        <i class="mr-2 text-white fas fa-print"></i>
        <span class="text-sm text-white print">Print</span>
    </button>

    <!-- Kembali Button -->
    <form action="{{ route('kembali_ke_laporan_penjualan') }}" method="get">
        <div class="fixed top-[2%] left-[4%] transform -translate-x-1/2">
            <button type="submit" class="bg-[#719192] text-white px-4 py-2 rounded hover:bg-[#5f7a7a] kembali">Kembali
        </div>
    </form>

    <div class="p-6 bg-white border rounded-lg shadow-lg print-container">
        <h1 class="text-xl font-bold text-center">Struk Pembayaran</h1>
        <p class="text-sm font-semibold text-center">New Spon Grosir Sandal</p>

        <div class="mb-4 text-center">
            <p class="text-sm text-gray-700">Terima kasih telah berbelanja dengan kami!</p>
            <p class="text-sm font-semibold">Kami sangat menghargai pilihan Anda!</p>
        </div>

        <p class="my-2 text-center">------------------------------------------</p>

        <div class="mt-2 text-center">
            <p class="text-sm font-semibold">Detail Transaksi:</p>
            <div class="flex justify-between my-1 text-xs">
                <span class="notrans">No Transaksi:</span>
                <span class="notrans-value">{{ str_pad($transaksi->nopenjualan, 8, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between my-1 text-xs">
                <span class="tanggal">Tanggal:</span>
                <span>{{ $transaksi->tanggal_pembayaran->format('d-m-Y H:i') }}</span>
            </div>
            <div class="flex justify-between my-1 text-xs">
                <span class="metode">Metode Pembayaran:</span>
                <span>{{ $transaksi->metode_pembayaran }}</span>
            </div>
            <div class="flex justify-between my-1 text-xs">
                <span class="status">Status:</span>
                <span>{{ $transaksi->status }}</span>
            </div>
        </div>

        <p class="my-2 text-center">------------------------------------------</p>

        <div class="mt-1 text-center">
            <p class="text-sm font-semibold">Detail Barang:</p>
            <div class="mt-2">
                @foreach ($detailTransaksi as $detail)
                    <div class="flex justify-between py-1 text-xs">
                        <div>
                            <div class="text-left">
                                <p class="font-medium">{{ $detail->kd_barang }}</p> <!-- Kode Barang -->
                                {{-- <p class="font-medium">{{ $detail-> }}</p> --}}
                            </div>
                            <p class="text-xs text-gray-600">Jumlah:
                                @if ($detail->satuan->nama_satuan == 'Pcs')
                                    {{ $detail->qty }} {{ $detail->satuan->nama_satuan }}
                                @elseif ($detail->satuan->nama_satuan == 'Kodi')
                                    {{ $detail->qty / 20 }} {{ $detail->satuan->nama_satuan }}
                                @endif
                            </p> <!-- Jumlah Barang -->
                        </div>
                        <div class="text-right">
                            <p class="font-medium">Rp {{ number_format($detail->subtotal, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <p class="my-2 text-center">------------------------------------------</p>

        <div class="flex justify-between text-xs font-semibold">
            <p>Total:</p>
            <p>Rp {{ number_format($transaksi->total, 2, ',', '.') }}</p>
        </div>

        <div class="flex justify-between text-xs font-semibold">
            <p>Bayar:</p>
            <p>Rp {{ number_format($transaksi->bayar, 2, ',', '.') }}</p>
        </div>

        <div class="flex justify-between text-xs font-semibold">
            <p>Kembalian:</p>
            <p>Rp {{ number_format($transaksi->kembalian, 2, ',', '.') }}</p>
        </div>

        <div class="mt-4 text-center">
            <p class="text-xs text-gray-600">Terima kasih atas pembelian Anda!</p>
        </div>
    </div>
</body>
<script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>


<script>
    //message with sweetalert
    @if (session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif (session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Data tidak valid!',
            text: 'Silakan periksa kembali input Anda.',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'blue-button' // Add the custom class here
            }
        });
    @endif
</script>

</html>
