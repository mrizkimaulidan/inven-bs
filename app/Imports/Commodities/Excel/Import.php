<?php

namespace App\Imports\Commodities\Excel;

use App\Commodity;
use App\CommodityLocation;
use App\SchoolOperationalAssistance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $commodity_location = CommodityLocation::where('name', $row['lokasi'])->first();
        $school_operational = SchoolOperationalAssistance::where('name', $row['asal_perolehan'])->first();
        // dd($school_operational);
        return new Commodity([
            'item_code' => $row['kode_barang'],
            'name' => $row['nama_barang'],
            'brand' => $row['merek'],
            'material' => $row['bahan'],
            'school_operational_assistance_id' => $school_operational->id,
            'commodity_location_id' => $commodity_location->id,
            'year_of_purchase' => $row['tahun_pembelian'],
            'condition' => $this->checkCommodityConditions($row['kondisi']),
            'quantity' => $row['kuantitas'],
            'price' => $row['harga'],
            'price_per_item' => $row['harga_satuan'],
            'note' => $row['keterangan']
        ]);
    }

    public function checkCommodityConditions($condition)
    {
        if ($condition === 'Baik') {
            $condition = 1;
        } elseif ($condition === 'Kurang Baik') {
            $condition = 2;
        } else {
            $condition = 3;
        }

        return $condition;
    }
}
