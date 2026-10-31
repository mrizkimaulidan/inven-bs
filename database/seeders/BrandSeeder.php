<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = collect(['IKEA', 'Livien', 'iFurnholic', 'Red Sun', 'JYSXK', 'Olympic', 'Informa', "Dove's", 'Funika', 'Atria', 'Vivere']);
        $now = now();

        $transformedData = $brands->map(fn (string $brand) => [
            'name' => $brand,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        Brand::insert($transformedData);
    }
}
