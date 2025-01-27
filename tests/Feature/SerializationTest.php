<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SerializationTest extends TestCase
{
    use RefreshDatabase;

    function testSerialization()
    {

        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::query()->get();
        self::assertCount(2, $product);

        $json = $product->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }

    function testSerializationRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::query()->get();
        $product->load("category");

        self::assertCount(2, $product);

        $json = $product->toJson(JSON_PRETTY_PRINT);
        LOG::info($json);
    }
}
