<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PembelianExport implements FromCollection, WithHeadings
{
    protected $start2;
    protected $end2;
    protected $pengeluaran;

    // Menentukan judul kolom di file Excel
    public function headings(): array
    {
        return [
            "No.",
            "No Pembelian",
            "Nama Pemasok",
            "Total",
            "Tanggal Pembayaran",
            "Waktu Pembayaran",
        ];
    }

    public function __construct($start2, $end2, $pengeluaran)
    {
        $this->start2 = $start2;
        $this->end2 = $end2;
        $this->pengeluaran = $pengeluaran;

        // Log output
        // Log::info('PenjualanExport constructed with data:', [
        //     'start' => $this->start,
        //     'end' => $this->end,
        // ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Pembelian::with('pemasok');

        // Tambahkan kondisi jika start2 dan end2 tidak null
        if ($this->start2 && $this->end2) {
            $query->whereRaw('DATE(tanggal_pembelian) BETWEEN ? AND ?', [$this->start2, $this->end2]);
        }

        $pembelians = $query->get();

        // Format data yang akan diekspor
        $data2 = $pembelians->map(function ($pembelian, $index) {
            return [
                $index + 1,
                "'" . $pembelian->nopembelian,
                $pembelian->pemasok->nama ?? 'N/A',
                'Rp. ' . number_format($pembelian->total, 0, ',', '.'),
                Carbon::parse($pembelian->tanggal_pembelian)->format('Y-m-d'),
                Carbon::parse($pembelian->tanggal_pembelian)->format('H:i:s'),
            ];
        });

        // Tambahkan baris untuk total pengeluaran
        $data2->push([
            '', // Kolom No.
            '', // Kolom No Pembelian
            'Total Pengeluaran', // Label untuk kolom Nama Pemasok
            'Rp. ' . number_format($this->pengeluaran, 0, ',', '.'), // Kolom Total Pengeluaran
            '', // Kolom Tanggal Pembayaran
            '', // Kolom Waktu Pembayaran
        ]);

        return $data2;
    }
}
