<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/** Run application seeders in dependency order. */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            MaterialSeeder::class,
            CommodityLocationSeeder::class,
            CommodityFundingSourceSeeder::class,
            CommoditySeeder::class,
        ]);

    }
}
