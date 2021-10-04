<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 50; ++$i) {
            DB::table('products')->insert([
                'product_category_id' => random_int(\DB::table('product_categories')->min('product_category_id'), \DB::table('product_categories')->max('product_category_id')),
                'product_name' => Str::random(10),
                'product_desc' => Str::random(100),
                'price' => random_int(0, 9) * 100 + random_int(0, 9) * 10 + random_int(0, 9) * 100 + (random_int(0, 9) / 100 + random_int(0, 9) * 10),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}
