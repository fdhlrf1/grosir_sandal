<x-slot:title>{{ $title }}</x-slot:title>
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

            /* Display only the content to be printed */
            .print-container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 100%;
                max-width: 400px;
                height: auto;
                padding: 20px;
                background-color: white;
                color: black;
                margin: 0 auto;
                /* Center the container */
                border: 1px solid black;
                font-family: Arial, sans-serif;
                font-size: 12px;
                /* Adjust font size for printing */
            }

            .separator {
                margin: 10px 0;
                border-top: 1px dashed black;
                width: 100%;
            }

            .detail {
                text-align: left;
                width: 100%;
            }

            .label {
                margin-right: 10px;
                /* Jarak antara label dan isi */
                font-weight: bold;
                /* Bold untuk label */
            }

            .total,
            .thank-you {
                text-align: center;
                margin-top: 20px;
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

    <div class="p-6 bg-white border rounded-lg shadow-lg print-container">
        <h1 class="text-xl font-bold text-center">Struk Pembayaran</h1>
        <p class="text-sm font-semibold text-center">New Spon Grosir Sandal</p>

        <div class="mb-4 text-center">
            <p class="text-sm text-gray-700">Terima kasih telah berbelanja dengan kami!</p>
            <p class="text-sm font-semibold">Kami sangat menghargai pilihan Anda!</p>
        </div>

        <div class="separator"></div>

        <div class="detail">
            <p class="text-sm font-semibold text-center">Detail Transaksi:</p>
            <div class="flex justify-between my-1 text-xs">
                <span class="label">No Transaksi:</span>
                <span>{{ str_pad($transaksi->nopenjualan, 8, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between my-1 text-xs">
                <span class="label">Tanggal:</span>
                <span>{{ $transaksi->tanggal_pembayaran->format('d-m-Y H:i') }}</span>
            </div>
            <div class="flex justify-between my-1 text-xs">
                <span class="label">Metode Pembayaran:</span>
                <span>{{ $transaksi->metode_pembayaran }}</span>
            </div>
            <div class="flex justify-between my-1 text-xs">
                <span class="label">Status:</span>
                <span>{{ $transaksi->status }}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="detail">
            <p class="text-sm font-semibold text-center">Detail Produk:</p>
            <div class="mt-2">
                @foreach ($detailTransaksi as $detail)
                    <div class="flex justify-between py-1 text-xs">
                        <div>
                            <p class="font-medium">{{ $detail->kd_barang }}</p> <!-- Kode Barang -->
                            <p class="text-xs text-gray-600 label">Jumlah: {{ $detail->qty }}</p>
                            <!-- Jumlah Barang -->
                        </div>
                        <div class="text-right">
                            <p class="font-medium">Rp
                                {{ number_format($detail->subtotal, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="separator"></div>

        <div class="flex justify-between text-xs font-semibold">
            <span class="label">Total:</span>
            <span>Rp {{ number_format($transaksi->total, 2, ',', '.') }}</span>
        </div>

        <div class="flex justify-between text-xs font-semibold">
            <span class="label">Bayar:</span>
            <span>Rp {{ number_format($transaksi->bayar, 2, ',', '.') }}</span>
        </div>

        <div class="flex justify-between text-xs font-semibold">
            <span class="label">Kembalian:</span>
            <span>Rp {{ number_format($transaksi->kembalian, 2, ',', '.') }}</span>
        </div>

        <div class="thank-you">
            <p class="text-xs text-gray-600">Terima kasih atas pembelian Anda!</p>
        </div>
    </div>
</body>

</html>
