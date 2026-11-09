<?php

namespace Database\Seeders;

use App\Models\CommodityFundingSource;
use Illuminate\Database\Seeder;

/** Seed the initial commodity funding sources. */
class CommodityFundingSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        CommodityFundingSource::factory()->count(10)->create();
    }
}
