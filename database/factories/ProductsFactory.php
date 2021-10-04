<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Products::class, function (Faker $faker) {
    return [
        'product_category_id' => random_int(\DB::table('product_categories')->min('product_category_id'), \DB::table('product_categories')->max('product_category_id')),
        'product_name' => Str::random(10),
        'product_desc' => Str::random(100),
        'price' => random_int(0, 9) * 100 + random_int(0, 9) * 10 + random_int(0, 9) * 100 + (random_int(0, 9) / 100 + random_int(0, 9) * 10),
        'updated_at' => $faker->dateTime(),
    ];
});
