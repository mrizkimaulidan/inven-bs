<?php

namespace App\Imports;

use App\CommodityLocation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommodityLocationsImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new CommodityLocation([
            'name' => $row['nama'],
            'description' => $row['deskripsi'],
        ]);
    }
}
