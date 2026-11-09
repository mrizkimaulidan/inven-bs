<?php

namespace Database\Factories;

use App\Enums\CommodityCondition;
use App\Models\Brand;
use App\Models\Commodity;
use App\Models\CommodityFundingSource;
use App\Models\CommodityLocation;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Commodity>
 */
class CommodityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $quantity = $faker->numberBetween(1, 50);
        $unitPrice = $faker->numberBetween(250_000, 30_000_000);
        $registeredAt = $faker->dateTimeBetween('-5 years', 'now');
        $updatedAt = $faker->dateTimeBetween($registeredAt, 'now');
        $purchaseYear = fake()->numberBetween(
            max(2010, (int) $registeredAt->format('Y') - 12),
            (int) $registeredAt->format('Y'),
        );
        $itemCode = 'INV-'.$faker->unique()->numerify('######');
        $conditionValue = $faker->numberBetween(1, 100);
        $condition = match (true) {
            $conditionValue <= 70 => CommodityCondition::GOOD,
            $conditionValue <= 95 => CommodityCondition::POOR,
            default => CommodityCondition::HEAVILY_DAMAGED,
        };

        return [
            'commodity_funding_source_id' => CommodityFundingSource::factory(),
            'commodity_location_id' => CommodityLocation::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'brand_id' => Brand::factory(),
            'material_id' => Material::factory(),
            'item_code' => $itemCode,
            'qr_code' => $faker->unique()->uuid(),
            'name' => $faker->words(2, true),
            'purchase_year' => $purchaseYear,
            'condition' => $condition->value,
            'image' => 'commodities/'.$faker->unique()->uuid().'.jpg',
            'quantity' => $quantity,
            'total_price' => $quantity * $unitPrice,
            'unit_price' => $unitPrice,
            'notes' => $faker->optional(0.65)->sentence(),
            'created_at' => $registeredAt,
            'updated_at' => $updatedAt,
        ];
    }
}
