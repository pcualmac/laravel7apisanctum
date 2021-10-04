<?php

use Illuminate\Database\Seeder;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; ++$i) {
            DB::table('product_categories')->insert([
                'name' => 'product_categories_'.$i,
                'parent_id' => null,
                'local' => 'en-gb',
            ]);
        }
        for ($i = 0; $i < 10; ++$i) {
            DB::table('product_categories')->insert([
                'name' => 'product_categories_fr-ch'.$i,
                'parent_id' => null,
                'local' => 'fr-ch',
            ]);
        }
    }
}
