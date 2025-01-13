<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenjualanExport implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;
    protected $metode_pembayaran;
    protected $status;
    protected $pendapatan;

    // Menentukan judul kolom di file Excel
    public function headings(): array
    {
        return [
            "No.",
            "No Penjualan",
            "Nama Konsumen",
            "Total",
            "Tanggal Pembayaran",
            "Waktu Pembayaran",
            "Metode Pembayaran",
            "Status"
        ];
    }

    public function __construct($start, $end, $metode_pembayaran, $status, $pendapatan)
    {
        $this->start = $start;
        $this->end = $end;
        $this->metode_pembayaran = $metode_pembayaran;
        $this->status = $status;
        $this->pendapatan = $pendapatan;

        // Log output
        // Log::info('PenjualanExport constructed with data:', [
        //     'start' => $this->start,
        //     'end' => $this->end,
        //     'metode_pembayaran' => $this->metode_pembayaran,
        //     'status' => $this->status,
        // ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Penjualan::with('konsumen'); // Pastikan relasi konsumen ditarik bersamaan

        // Tambahkan kondisi jika start dan end tidak null
        if ($this->start && $this->end) {
            $query->whereRaw('DATE(tanggal_pembayaran) BETWEEN ? AND ?', [$this->start, $this->end]);
        }

        // Filter berdasarkan metode pembayaran jika ada
        if ($this->metode_pembayaran) {
            $query->where('metode_pembayaran', $this->metode_pembayaran);
        }

        // Filter berdasarkan status jika ada
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $penjualans = $query->get();

        // Format data yang akan diekspor
        $data = $penjualans->map(function ($penjualan, $index) {
            return [
                $index + 1,
                "'" . $penjualan->nopenjualan,
                $penjualan->konsumen->nama ?? 'N/A',
                'Rp. ' . number_format($penjualan->total, 0, ',', '.'),
                Carbon::parse($penjualan->tanggal_pembayaran)->format('Y-m-d'),
                Carbon::parse($penjualan->tanggal_pembayaran)->format('H:i:s'),
                $penjualan->metode_pembayaran,
                $penjualan->status === 'Belum Lunas' ? 'Belum Lunas' : 'Lunas',
            ];
        });

        // Menambahkan baris total pendapatan di akhir data
        $data->push([
            '',
            '',
            'Total Pendapatan',
            'Rp. ' . number_format($this->pendapatan, 0, ',', '.'),
            '',
            '',
            '',
            ''
        ]);

        return $data;
    }
}
