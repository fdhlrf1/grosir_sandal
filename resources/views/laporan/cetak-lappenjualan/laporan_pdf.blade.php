<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 3px;
            background-color: #ffffff;
            color: #000000;
            font-size: 12px;
        }

        .container {
            max-width: 100%;
            margin: auto;
            padding: 0 10px;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 12px;
            text-align: center;
        }

        .header-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .header-info div {
            margin-bottom: 4px;
            width: 48%;
        }

        .header-info span {
            margin-left: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        th,
        td {
            padding: 4px;
            text-align: center;
            border: 1px solid #000000;
            word-wrap: break-word;
        }

        th {
            background-color: #f0f0f0;
        }

        /* Batasi lebar kolom */
        td:nth-child(1) {
            width: 3%;
        }

        /* No */
        td:nth-child(2) {
            width: 10%;
        }

        /* Petugas */
        td:nth-child(3) {
            width: 12%;
        }

        /* No Penjualan */
        td:nth-child(4) {
            width: 12%;
        }

        /* Konsumen */
        td:nth-child(5) {
            width: 10%;
        }

        /* Total */
        td:nth-child(6) {
            width: 10%;
        }

        /* Tanggal */
        td:nth-child(7) {
            width: 10%;
        }

        /* Waktu */
        td:nth-child(8) {
            width: 12%;
        }

        /* Metode */
        td:nth-child(9) {
            width: 10%;
        }

        /* Status */

        .no-data {
            background-color: #fed7e2;
            color: #e53e3e;
            text-align: center;
        }

        .status {
            display: inline-block;
            padding: 2px 4px;
            font-weight: bold;
        }

        @media print {
            body {
                margin: 5mm;
            }

            .container {
                border: none;
                width: auto;
            }

            table {
                border: 1px solid #000;
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
        <h1>Laporan Penjualan</h1>
        <div class="header-info">
            <div>
                Periode:
                <span>
                    @if (empty($start) && empty($end) && empty($metode) && empty($status))
                        Semua Periode
                    @else
                        {{ request('start') }} - {{ request('end') }}
                    @endif
                </span>
            </div>
            <div>
                Metode Pembayaran: <span>{{ request('metode_pembayaran') ?? 'Semua Metode' }}</span>
            </div>
            <div>
                Status Pembayaran: <span>{{ request('status') ?? 'Semua Status' }}</span>
            </div>
            <div>
                Total Pendapatan: <span>Rp. {{ number_format($pendapatan, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tabel Laporan Penjualan -->
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Petugas</th>
                    <th>No Penjualan</th>
                    <th>Nama Konsumen</th>
                    <th>Total</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Waktu Pembayaran</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $penjualan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penjualan->user->name }}</td>
                        <td>{{ $penjualan->nopenjualan }}</td>
                        <td>{{ $penjualan->konsumen->nama }}</td>
                        <td>Rp. {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_pembayaran)->format('H:i:s') }}</td>
                        <td>{{ $penjualan->metode_pembayaran }}</td>
                        <td>
                            <span class="status">{{ $penjualan->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="no-data">Data Penjualan belum Tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
