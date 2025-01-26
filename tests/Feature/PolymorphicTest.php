<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PolymorphicTest extends TestCase
{

    use RefreshDatabase;

    function testOneToOnePolymorphic()
    {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::find("budi");
        self::assertNotNull($customer);

        $image = $customer->image;

        Log::info(json_encode($image, JSON_PRETTY_PRINT));

        self::assertNotNull($image);
        self::assertEquals('https://picsum.photos/536/354', $image->url);

    }

    function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::first();
        $comments = $product->comments;

        self::assertCount(1, $comments);
        foreach ($comments as $comment) {
            self::assertEquals('product', $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
            Log::info($comment);
        }


    }

    function testOneOfManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::first();

        $latestComment = $product->latestComment;
        self::assertNotNull($latestComment);

        $oldestComment = $product->oldestComment;
        self::assertNotNull($oldestComment);

        Log::info(json_encode(['latest' => $latestComment, 'oldest' => $oldestComment], JSON_PRETTY_PRINT));
    }

    function testManyToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);

        $product = Product::query()->first();
        $tags = $product->tags;

        self::assertNotNull($tags);
        self::assertCount(1, $tags);

        foreach ($tags as $tag) {
            self::assertNotNull($tag);
            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);
            Log::info(json_encode($tag, JSON_PRETTY_PRINT));
        }
    }

    public function testQueryingRelations()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        $product = $category->products()->where("price", 200)->get();
        self::assertCount(1, $product);
    }
}
