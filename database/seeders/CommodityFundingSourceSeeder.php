<?php

namespace Database\Seeders;

use App\Models\CommodityFundingSource;
use Illuminate\Database\Seeder;

class CommodityFundingSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = collect(['BOSNAS', 'BOSDA']);
        $now = now();

        $transformedData = $sources->map(fn (string $source) => [
            'name' => $source,
            'description' => "Deskripsi: $source",
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        CommodityFundingSource::insert($transformedData);
    }
}
