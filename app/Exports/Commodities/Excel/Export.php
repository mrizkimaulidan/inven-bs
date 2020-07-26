<?php

namespace App\Exports\Commodities\Excel;

use App\Commodity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Export implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $commodities = Commodity::all();

        return collect([
            $this->customProcessDataCommoditiesToExcel($commodities)
        ]);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Kode Barang',
            'Nama Barang',
            'Merek',
            'Bahan',
            'Asal Perolehan',
            'Lokasi',
            'Tahun Pembelian',
            'Kondisi',
            'Kuantitas',
            'Harga',
            'Harga Satuan',
            'Keterangan'
        ];
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->setAllBorders('thin')->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            }
        ];
    }

    public function customProcessDataCommoditiesToExcel($model)
    {
        foreach ($model as $key => $commodity) {
            $data[$key]['no'] = $key + 1;
            $data[$key]['item_code'] = $commodity->item_code;
            $data[$key]['name'] = $commodity->name;
            $data[$key]['brand'] = $commodity->brand;
            $data[$key]['material'] = $commodity->material;
            $data[$key]['school_operational_assistance_id'] = $commodity->school_operational_assistance->name;
            $data[$key]['location'] = $commodity->commodity_location->name;
            $data[$key]['year_of_purchase'] = $commodity->year_of_purchase;
            $data[$key]['condition'] = $this->checkCommodityConditions($commodity);
            $data[$key]['quantity'] = $commodity->quantity;
            $data[$key]['price'] = $commodity->price;
            $data[$key]['price_per_item'] = $commodity->price_per_item;
            $data[$key]['note'] = $commodity->note;
        }

        return $data;
    }

    public function checkCommodityConditions($commodity)
    {
        if ($commodity->condition === 1) {
            $condition = 'Baik';
        } elseif ($commodity->condition === 2) {
            $condition = 'Kurang Baik';
        } else {
            $condition = 'Rusak Berat';
        }

        return $condition;
    }
}
