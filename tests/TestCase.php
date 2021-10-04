<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createProductCategory($args = [])
    {
        return factory(\App\ProductCategory::class)->create($args);
    }

    public function createProducts($args = [])
    {
        return factory(\App\Products::class)->create($args);
    }

    public function createProductsWithCategory($args = [])
    {
        $factory_product_category = factory(\App\ProductCategory::class)->create($args);
        $factory_product_with_category = factory(\App\Products::class)->create(['product_category_id' => $factory_product_category->id]);

        return $factory_product_with_category;
    }

    public function authUser()
    {
        $user = $this->createUser();
        Sanctum::actingAs($user);

        return $user;
    }

    public function createUser($args = [])
    {
        return factory(\App\User::class)->create($args);
    }
}
