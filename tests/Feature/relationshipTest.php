<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class relationshipTest extends TestCase
{

    function setUp(): void
    {
        parent::setUp();
        Wallet::query()->delete();
        Customer::query()->delete();
        Product::query()->delete();
        Category::query()->forceDelete();
    }

    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find("budi");
        self::assertNotNull($customer);

        // $wallet = Wallet::where("customer_id", $customer->id)->first();
        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(1000000, $wallet->amount);
    }

    function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);

        $category = Category::find("FOOD");
        self::assertNotNull($category);

        $relProduct = $category->products;
        self::assertNotNull($relProduct);
        self::assertCount(1, $relProduct);

    }

    function testInsertRelationshipOneToOne()
    {
        $customer = new Customer();
        $customer->id = "BUDI";
        $customer->name = "budi";
        $customer->email = "budi@gmail.com";
        $customer->save();

        self::assertNotNull($customer);

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);

        self::assertNotNull($customer->wallet);
    }

    function testInsertRelationshipOneToMany()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = true;
        $category->save();

        $product = new Product();
        $product->id = "1";
        $product->name = "Product 1";
        $product->description = "Product 1 description";
        $product->category_id = "FOOD";
        $category->products()->save($product);

//        $data = Product::find("1");
//        self::assertNotNull($data);

        $category = Category::query()->find("FOOD");

        $outOfStockProduct = $category->products()->where("stock",'<=',"0")->get();
        self::assertNotNull($outOfStockProduct);
        self::assertCount(1,$outOfStockProduct);

    }
}
