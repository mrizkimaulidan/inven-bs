<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = collect(['Kayu Solid', 'Kayu Lapis', 'Blockboard', 'MDF', 'Melaminto', 'Partikel', 'Rotan']);

        $now = now();
        $transformedData = $materials->map(fn (string $material) => [
            'name' => $material,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        Material::insert($transformedData);
    }
}
