<?php

namespace App\Imports\Commodities\Excel;

use App\Commodity;
use App\CommodityLocation;
use App\SchoolOperationalAssistance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class Import implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $commodity_location = CommodityLocation::where('name', $row[7])->first();
        $school_operational = SchoolOperationalAssistance::where('name', $row[6])->first();
// dd($row);
        return new Commodity([
            // 'register' => $row[1],
            'item_code' => $row[2],
            'name' => $row[3],
            'brand' => $row[4],
            'material' => $row[5],
            'school_operational_assistance_id' => $school_operational->id,
            'commodity_location_id' => $commodity_location->id,
            'year_of_purchase' => $row[8],
            'condition' => $this->checkCommodityConditions($row[9]),
            'quantity' => $row[10],
            'price' => $row[11],
            'price_per_item' => $row[12],
            'note' => $row[13]
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
