<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

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
}
