<?php

namespace Database\Seeders;

use App\CommodityAcquisition;
use Illuminate\Database\Seeder;

class CommodityAcquisitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commodityAcquisitions = ['BOSDA', 'BOSNAS'];

        foreach ($commodityAcquisitions as $commodityAcquisition) {
            CommodityAcquisition::create([
                'name' => $commodityAcquisition,
                'description' => "Deskripsi $commodityAcquisition",
            ]);
        }
    }
}
