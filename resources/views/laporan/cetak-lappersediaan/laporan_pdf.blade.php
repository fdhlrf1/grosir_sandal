<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Persediaan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Aturan umum */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 3px;
            background-color: #ffffff;
            color: #000000;
        }

        .container {
            max-width: 800px;
            /* Ukuran kontainer */
            margin: auto;
            padding: 0;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header-info div {
            margin-bottom: 0;
            font-weight: bold;
        }

        .header-info span {
            margin-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border: 1px solid #000000;
        }

        th {
            background-color: #f0f0f0;
        }

        /* Mengatur lebar kolom Total Pembayaran */
        td:nth-child(4) {
            width: 20%;
            /* Atur lebar kolom Total Pembayaran sesuai kebutuhan */
        }

        .no-data {
            background-color: #fed7e2;
            color: #e53e3e;
            text-align: center;
        }

        .status {
            display: inline-block;
            padding: 5px;
            font-weight: bold;
        }

        /* Media print untuk cetakan */
        @media print {
            body {
                margin: 10mm;
                /* Margin: atas, kanan, bawah, kiri */
            }

            .container {
                border: none;
                width: auto;
                /* Agar lebar otomatis mengikuti margin */
            }

            h1 {
                margin-bottom: 20px;
            }

            table {
                border: 1px solid #000;
                width: 100%;
                /* Pastikan tabel mengisi lebar */
            }

            th,
            td {
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Laporan -->
        <h1>Laporan Persediaan</h1>
        <div class="header-info">
            <div>
                Periode:
                <span>
                    {{ $now }}
                </span>
            </div>
        </div>

        <!-- Tabel Laporan Persediaan -->
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kategori Barang</th>
                    <th>Stok Keseluruhan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($persediaans as $persediaan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="px-3 py-4 border border-slate-300">{{ $persediaan->kategori }}</td>
                        <td>{{ $persediaan->total_stok / 20 }} Kodi</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="no-data">Data Persediaan belum Tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
