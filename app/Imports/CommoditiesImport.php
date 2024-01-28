<?php

namespace App\Imports;

use App\Commodity;
use App\CommodityLocation;
use App\SchoolOperationalAssistance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CommoditiesImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $commodity_location = CommodityLocation::where('name', $row['lokasi'])->first();
        $school_operational = SchoolOperationalAssistance::where('name', $row['asal_perolehan'])->first();

        return new Commodity([
            'item_code' => $row['kode_barang'],
            'name' => $row['nama_barang'],
            'brand' => $row['merek'],
            'material' => $row['bahan'],
            'school_operational_assistance_id' => $school_operational->id,
            'commodity_location_id' => $commodity_location->id,
            'year_of_purchase' => $row['tahun_pembelian'],
            'condition' => $this->translateConditionNameToNumber($row['kondisi']),
            'quantity' => $row['kuantitas'],
            'price' => $row['harga'],
            'price_per_item' => $row['harga_satuan'],
            'note' => $row['keterangan']
        ]);
    }

    /**
     * Translate condition name to the corresponding number.
     */
    public function translateConditionNameToNumber($conditionName)
    {
        return match ($conditionName) {
            'Baik' => 1,
            'Kurang Baik' => 2,
            'Rusak Berat' => 3,
        };
    }

    /**
     * Specify the unique column used for upsert operations.
     */
    public function uniqueBy()
    {
        return 'item_code';
    }
}
