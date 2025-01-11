<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class CategoryTest extends TestCase
{

    function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM categories");
    }

    function testInsert()
    {
        $category = new Category();

        $category->id = "GADGET";
        $category->name = "gadget";

        $result = $category->save();

        self::assertTrue($result);
    }

    function testInsertManyCategories()
    {
        $categories = [];

        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "name $i",
            ];
        }

        $result = Category::query()->insert($categories);
//        $result = Category::insert(collect($categories));
        self::assertTrue($result);

        $total = Category::query()->count();
//        $total = Category::count();
        self::assertEquals(10, $total);

    }

    function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");

//        var_dump($category);

        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
        self::assertEquals("Food", $category->name);
        self::assertEquals("Food Category", $category->description);

    }

    function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");
        $category->name = "test update";

        $result = $category->update();

        self::assertTrue($result);

    }

    function testSelect()
    {
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "name $i";

            $category->save();
        }

        $collection = Category::query()->whereNull("description")->get();
        self::assertCount(10, $collection);
        for ($i = 0; $i < count($collection); $i++) {
            self::assertNotNull($collection[$i]);
        }

        $collection->each(function ($params){
           $params->description = "Update Description";
           $params->update();
        });

    }
}
