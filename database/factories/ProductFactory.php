<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug'=> $faker->slug,
        'details' => $faker->words($nb = 4, $asText = true), 
        'price' => rand(1499, 24999),
        'description' => $faker->paragraphs($nb = 3, $asText = true),
    ];
});
