<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersediaanExport implements FromCollection, WithHeadings
{
    protected $persediaans;

    public function __construct($persediaans)
    {
        $this->persediaans = $persediaans;
    }

    public function collection()
    {
        return $this->persediaans;
    }

    public function headings(): array
    {
        return [
            'Kategori Barang',
            'Stok Dalam Pcs',
        ];
    }
}
