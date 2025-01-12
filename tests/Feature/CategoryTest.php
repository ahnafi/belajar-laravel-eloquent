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

        $collection->each(function ($params) {
            $params->description = "Update Description";
            $params->update();
        });

    }

    function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [

                "id" => "ID $i",

                "name" => "name $i"
            ];
        }

        self::assertTrue(Category::query()->insert($categories));

//        $collection->each(function ($params){
//           $params->description = "Update Description";
//           $params->update();
//        });

        Category::query()->whereNull("description")->update([
            "description" => "updated"
        ]);

        $collection = Category::query()->where("description", "updated")->get();

        self::assertCount(10, $collection);

    }

    function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");
        $result = $category->delete();

        self::assertTrue($result);

        $total = Category::query()->get();
        self::assertCount(0, $total);
    }

    function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [

                "id" => "ID $i",

                "name" => "name $i"
            ];
        }

        $result = Category::query()->insert($categories);
        self::assertTrue($result);

        $total = Category::query()->whereNull("description")->get();
        self::assertCount(10, $total);

        Category::query()->whereNull("description")->delete();

        $total = Category::query()->get();
        self::assertCount(0, $total);

    }

    function testCreate()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

//        Category::query()->insert($request);
        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    function testCreateMethod()
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category"
        ];

        $category = Category::query()->create($request);

        self::assertNotNull($category->id);
    }

    function testUpdateModel()
    {

        $this->seed(CategorySeeder::class);

        $request = [
            "name" => "food category",
            "description" => "food description"
        ];

        $category = Category::query()->find("FOOD");
        $category->fill($request);
        $category->save();

        self::assertNotNull($category->id);

    }
}
