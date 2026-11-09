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
        Material::factory()->count(16)->create();
    }
}
