<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Commodity;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Commodity::class, function (Faker $faker) {
    $carbon = new Carbon();
    return [
        'school_operational_assistance_id' => mt_rand(1, 2),
        'commodity_location_id' => mt_rand(1, 10),
        'item_code' => 'BRG-' . mt_rand(1000, 9999),
        'register' => 'RG-' . mt_rand(1000, 9999),
        'name' => $faker->realText(30),
        'brand' => $faker->realText(30),
        'material' => $faker->realText(30),
        'year_of_purchase' => $carbon->createFromDate('2020', mt_rand(1, 12), mt_rand(1, 31)),
        'condition' => mt_rand(1, 3),
        'quantity' => mt_rand(500, 1000),
        'price' => mt_rand(10000, 100000),
        'price_per_item' => mt_rand(5000, 25000),
        'note' => $faker->realText(50)
    ];
});
