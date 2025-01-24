<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VoucherSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LazyAndEagerLoadingTest extends TestCase
{
    use RefreshDatabase;

    function testEagerLoading()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class,]);

        $customer = Customer::with(["wallet", 'image'])->find('budi');

        self::assertNotNull($customer);
        self::assertEquals('1000000', $customer->wallet->amount);

        $product = Product::with('comments')->find('1');

        Log::info(json_encode($product, JSON_PRETTY_PRINT));

    }

    function testEagerLoadingInModel()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::find('budi');
        self::assertNotNull($customer);
        Log::info($customer);
    }
}
