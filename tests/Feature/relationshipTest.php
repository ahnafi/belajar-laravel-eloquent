<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Review;
use App\Models\VirtualAccount;
use App\Models\Wallet;
use Cassandra\Custom;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class relationshipTest extends TestCase
{

    function setUp(): void
    {
        parent::setUp();
        VirtualAccount::query()->delete();
        Wallet::query()->delete();
        DB::delete('delete from customers_likes_products');
        Review::query()->delete();
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
        self::assertCount(2, $relProduct);

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

        $outOfStockProduct = $category->products()->where("stock", '<=', "0")->get();
        self::assertNotNull($outOfStockProduct);
        self::assertCount(1, $outOfStockProduct);

    }

    function testHasOneOFMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find('FOOD');
        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals(200, $cheapestProduct->price);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals(1000000, $mostExpensiveProduct->price);
    }

    function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::query()->find("budi");
        self::assertNotNull($customer);

        $va = $customer->virtualAccount;
        self::assertNotNull($va);
        self::assertEquals('BCA', $va->bank);
    }

    function testHasManyThrough()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

        $category = Category::query()->find("FOOD");
        self::assertNotNull($category);

        $reviews = $category->reviews;
        self::assertNotNull($reviews);
        self::assertCount(2, $reviews);
    }

    public function testInsertManyToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class]);

        $customer = Customer::query()->find('budi');
        $customer->likeProducts()->attach('1');

        self::assertNotNull($customer->id);
    }

    public function testQueryManyToMany()
    {
        $this->testInsertManyToMany();

        $customer = Customer::query()->find("budi");
        $products = $customer->likeProducts;
        self::assertNotNull($products);

        self::assertEquals('1', $products[0]->id);
        self::assertEquals('Product 1', $products[0]->name);

    }

    public function testRemoveManyToMany()
    {
        $this->testInsertManyToMany();

        $customer = Customer::query()->find('budi');
        $customer->likeProducts()->detach("1");
        $products = $customer->likeProducts;

        self::assertNotNull($products);
        self::assertCount(0, $products);
    }

    public function testPivotAttribute()
    {
        $this->testInsertManyToMany();

        $customer = Customer::find("budi");
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            Log::info($pivot);
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->created_at);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
        }
    }

    public function testPivotAttributeCondition()
    {
        $this->testInsertManyToMany();


        $customer = Customer::find("budi");
        $products = $customer->likeProductsLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            Log::info($pivot);
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->created_at);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
        }

    }

}
