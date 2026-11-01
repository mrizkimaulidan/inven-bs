<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

/** Seed the initial commodity brands. */
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $brandNames = collect(['IKEA', 'Livien', 'iFurnholic', 'Red Sun', 'JYSXK', 'Olympic', 'Informa', "Dove's", 'Funika', 'Atria', 'Vivere']);
        $now = now();

        $brandRecords = $brandNames->map(fn (string $brandName) => [
            'name' => $brandName,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        Brand::insert($brandRecords);
    }
}
