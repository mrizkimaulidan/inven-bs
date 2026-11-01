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
        $fundingSourceNames = collect(['BOSNAS', 'BOSDA']);
        $now = now();

        $fundingSourceRecords = $fundingSourceNames->map(fn (string $fundingSourceName) => [
            'name' => $fundingSourceName,
            'description' => "Deskripsi: $fundingSourceName",
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        CommodityFundingSource::insert($fundingSourceRecords);
    }
}
