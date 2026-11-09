<?php

namespace Database\Factories;

use App\Models\CommodityFundingSource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommodityFundingSource>
 */
class CommodityFundingSourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, string>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'name' => $faker->unique()->words(2, true),
            'description' => $faker->sentence(),
        ];
    }
}
