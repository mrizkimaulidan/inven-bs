<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

/** Seed the initial commodity materials. */
class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $materialNames = collect(['Kayu Solid', 'Kayu Lapis', 'Blockboard', 'MDF', 'Melaminto', 'Partikel', 'Rotan']);

        $now = now();
        $materialRecords = $materialNames->map(fn (string $materialName) => [
            'name' => $materialName,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        Material::insert($materialRecords);
    }
}
