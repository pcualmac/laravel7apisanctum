<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function test_fetch_all_product_of_a_local_en_gb()
    {
        $product = $this->createProductsWithCategory(['local' => 'en-gb']);
        $product_fr = $this->createProductsWithCategory(['local' => 'fr-ch']);
        $product_en = $this->createProductsWithCategory(['local' => 'en-gb']);

        $response = $this->getJson(route('product'))->assertOk()->json('data');
        $this->assertEquals(2, count($response));
        $this->assertEquals($product->product_name, $response[0]['product_name']);
    }

    public function test_fetch_all_product_of_a_local_fr_ch()
    {
        $product = $this->createProductsWithCategory(['local' => 'en-gb']);
        $product_fr = $this->createProductsWithCategory(['local' => 'fr-ch']);
        $product_en = $this->createProductsWithCategory(['local' => 'en-gb']);
        $response = $this->getJson(route('product'), ['x-xsfr-token' => 'fr-ch'])->assertOk()->json('data');
        $this->assertEquals(1, count($response));
        $this->assertEquals($product_fr->product_name, $response[0]['product_name']);
    }

    public function test_store_a_product_for_en_gb()
    {
        $product = $this->createProductsWithCategory(['local' => 'en-gb']);
        $this->postJson(route('product.store'), $product->toArray());
        $this->assertDatabaseHas('products', [
            'product_name' => $product->product_name,
            'product_desc' => $product->product_desc,
            'product_category_id' => $product->product_category_id,
            'price' => $product->price,
        ]);
    }

    public function test_store_a_product_for_fr_ch()
    {
        $product = $this->createProductsWithCategory(['local' => 'fr-ch']);
        $this->postJson(route('product.store'), $product->toArray());
        $this->assertDatabaseHas('products', [
            'product_name' => $product->product_name,
            'product_desc' => $product->product_desc,
            'product_category_id' => $product->product_category_id,
            'price' => $product->price,
        ]);
    }

    public function test_delete_a_product_from_database_fr_ch()
    {
        $product = $this->createProductsWithCategory(['local' => 'fr-ch']);

        $delete = [
            'product_id' => $product->id,
            'product_category_id' => $product->product_category_id,
        ];
        $response = $this->withHeaders([
            'x-xsfr-token' => 'fr-ch',
        ])->json('POST', route('product.destroy', $delete));
        $this->assertEquals($response['status_code'], 200);
        $this->assertSoftDeleted('products', ['product_name' => $response['data']['product_name']]);
    }

    public function test_delete_a_product_from_database()
    {
        $product = $this->createProductsWithCategory(['local' => 'en-gb']);

        $delete = [
            'product_id' => $product->id,
            'product_category_id' => $product->product_category_id,
        ];
        $response = $this->postJson(route('product.destroy', $delete))
            ->assertOk()->json('data');
        $this->assertSoftDeleted('products', ['product_name' => $response['product_name']]);
    }

    public function test_update_a_product()
    {
        $product = $this->createProductsWithCategory(['local' => 'en-gb']);
        $update = $product->toArray();
        $update['product_id'] = $product->id;
        $update['product_name'] = 'updated name';
        unset($update['product_category']);
        $response = $this->json('POST', route('product.update', $update));

        $this->assertDatabaseHas('products', ['product_name' => 'updated name']);
    }

    public function test_update_a_product_fr_ch()
    {
        $product = $this->createProductsWithCategory(['local' => 'fr-ch']);
        $update = $product->toArray();
        $update['product_id'] = $product->id;
        $update['product_name'] = 'updated name';
        unset($update['product_category']);
        $response = $this->withHeaders([
            'x-xsfr-token' => 'fr-ch',
        ])->json('POST', route('product.update', $update));
        $this->assertEquals($response['status_code'], 200);
        $this->assertDatabaseHas('products', ['product_name' => 'updated name']);
    }
}
