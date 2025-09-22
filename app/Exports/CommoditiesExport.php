<?php

namespace App\Exports;

use App\Commodity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommoditiesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Commodity::with('commodity_acquisition', 'commodity_location')->get();
    }

    /**
     * Specify the headings for the exported file.
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Merek',
            'Bahan',
            'Asal Perolehan',
            'Lokasi Barang',
            'Tahun Pembelian',
            'Kondisi',
            'Kuantitas',
            'Harga',
            'Harga Satuan',
            'Keterangan',
        ];
    }

    /**
     * Map each row of the collection to an array for export.
     */
    public function map($row): array
    {
        static $i = 0;

        $i++;

        return [
            $i,
            $row->item_code,
            $row->name,
            $row->brand,
            $row->material,
            $row->commodity_acquisition->name,
            $row->commodity_location->name,
            $row->year_of_purchase,
            $row->getConditionName(),
            $row->quantity,
            $row->price,
            $row->price_per_item,
            $row->note,
        ];
    }
}
