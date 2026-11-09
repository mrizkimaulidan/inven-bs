<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Seed sample commodities with catalog relationships. */
class CommoditySeeder extends Seeder
{
    private const COMMODITY_COUNT = 1000;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $locationIds = CommodityLocation::query()->pluck('id');
        $fundingSourceIds = CommodityFundingSource::query()->pluck('id');
        $brandIds = Brand::query()->pluck('id');
        $materialIds = Material::query()->pluck('id');
        $userIds = User::query()->pluck('id');

        Commodity::factory()
            ->count(self::COMMODITY_COUNT)
            ->state(fn (): array => [
                'commodity_location_id' => $locationIds->random(),
                'commodity_funding_source_id' => $fundingSourceIds->random(),
                'brand_id' => $brandIds->random(),
                'material_id' => $materialIds->random(),
                'created_by' => $userIds->random(),
                'updated_by' => $userIds->random(),
            ])
            ->create();
    }
}
