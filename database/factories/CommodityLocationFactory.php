<?php

namespace Database\Factories;

use App\Models\CommodityLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommodityLocation>
 */
class CommodityLocationFactory extends Factory
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
            'name' => $faker->unique()->city().' - '.$faker->streetName(),
            'description' => $faker->sentence(),
        ];
    }
}
